# calcModa.R : Calcular el modo de las preguntas con escala nominal

Mode <- function(x) {
  ux <- unique(x)
  ux[which.max(tabulate(match(x, ux)))]
}

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT O.Texto from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion where O.idPregunta = ',idP,sep='')
dbGetQuery(con, sql) -> datos
mod <- Mode(datos$Texto)
mod
dbDisconnect(con)