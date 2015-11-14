# calcFrecuenciasPonderadas.R : Calculo de frecuencias ponderadas para escalas likerts

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto AS opcion, C.Texto as columna,C.Ponderacion, (SELECT COUNT(*) FROM respuestaspreguntas R where R.idOpcion = O.idOpcion AND R.idColumna = C.idColumna) AS cantidad from columnaspreguntas C LEFT JOIN opcionespreguntas O ON O.idPregunta = C.idPregunta where O.idPregunta = ',idP,' ORDER BY O.Texto, C.Ponderacion',sep='')
datos <- dbGetQuery(con, sql)
data_ordered = datos[with(datos, order(columna)), ]
data = data_ordered$cantidad * data_ordered$Ponderacion
cols <- unique(data_ordered[2])
rows <- unique(data_ordered[1])
data = matrix(data, ncol =length(cols$columna) , nrow=length(rows$opcion)) 
colnames(data) = cols$columna
rownames(data) = rows$opcion
data
dbDisconnect(con)