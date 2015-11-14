# grafPearson.R : 

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP1 <- args[1]
idP2 <- args[2]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste('SELECT R.RespuestaTexto,P.Texto FROM respuestaspreguntas R INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE R.idPregunta = ',idP1,sep='')
dbGetQuery(con, sql) -> datosx
sql <- paste('SELECT R.RespuestaTexto,P.Texto FROM respuestaspreguntas R INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE R.idPregunta = ',idP2,sep='')
dbGetQuery(con, sql) -> datosy
x <- as.numeric(datosx$RespuestaTexto)
y <- as.numeric(datosy$RespuestaTexto)
xtitulo <- datosx$Texto
ytitulo <- datosy$Texto
nom <- paste('../Datos/img/grafPearson',idP1,idP2,'.png',sep='')
png(file=nom)
plot(x, y, main=paste0(xtitulo[1]," vs ",ytitulo[1], " (cor= ", formatC(cor(y,x), 3, format="f"),")"), xlab=xtitulo[1], ylab=ytitulo[1])
dev.off()
dbDisconnect(con)