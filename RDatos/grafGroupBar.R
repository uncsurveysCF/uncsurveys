# grafGroupBar.R : Grafico de barra para escalas likerts

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT (CASE WHEN LENGTH(O.Texto) > 9 THEN O.idOpcion ELSE O.Texto END)  AS opcion, C.Texto as columna, (SELECT COUNT(*) FROM respuestaspreguntas R where R.idOpcion = O.idOpcion AND R.idColumna = C.idColumna) AS cantidad from columnaspreguntas C LEFT JOIN opcionespreguntas O ON O.idPregunta = C.idPregunta where O.idPregunta = ',idP,' ORDER BY C.Ponderacion',sep='')
datos <- dbGetQuery(con, sql)
data_ordered = datos[with(datos, order(opcion)), ]
data = data_ordered$cantidad
cols <- unique(data_ordered[2])
rows <- unique(data_ordered[1])
data = matrix(data, ncol = length(rows$opcion), nrow=length(cols$columna)) 
colnames(data) = rows$opcion
rownames(data) = cols$columna
nom <- paste('../Datos/img/graBarGroup',idP,'.png',sep='')
png(file=nom)
prop = prop.table(data, margin = 1)
d <- length(rows$opcion)
if( d > 6){
    barplot(data , col = rainbow(length(cols$columna)),cex.names=0.65,srt=45, width = 3,horiz=TRUE, beside = TRUE)
}else
{
   barplot(data , col = rainbow(length(cols$columna)),cex.names=0.65,srt=45, width = 3,beside = TRUE)
}
legend("topright", cols$columna, cex=0.6,bty="n", fill=rainbow(length(cols$columna)));
dev.off()
dbDisconnect(con)