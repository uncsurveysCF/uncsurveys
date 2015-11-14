# calcPerceptiles.R : Calcular quartiles de las preguntas con escala ordinal

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto,O.Orden from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion where O.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
mod <- quantile(datos$Orden, c(0.25,0.75), type = 1)
mod
dbDisconnect(con)