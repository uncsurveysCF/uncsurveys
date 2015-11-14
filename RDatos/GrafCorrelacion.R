# grafCorrelacion.R : 

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP1 <- args[1]
idTipo1 <- args[2]
idP2 <- args[3]
idTipo2 <- args[4]
metodo <- args[5]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
if(idTipo1 == "1"){
    sql <- paste('SELECT O.Orden AS RespuestaTexto,P.Texto from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE O.idPregunta = ',idP1,sep='')
}else{
    sql <- paste('SELECT R.RespuestaTexto,P.Texto FROM respuestaspreguntas R INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE R.idPregunta = ',idP1,sep='')
}
dbGetQuery(con, sql) -> datosx
if(idTipo2 == "1"){
    sql <- paste('SELECT O.Orden AS RespuestaTexto,P.Texto from opcionespreguntas O INNER JOIN respuestaspreguntas R ON O.idOpcion = R.idOpcion INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE O.idPregunta = ',idP2,sep='')
}else{
    sql <- paste('SELECT R.RespuestaTexto,P.Texto FROM respuestaspreguntas R INNER JOIN preguntasencuestas P ON R.idpregunta = P.idPregunta WHERE R.idPregunta = ',idP2,sep='')
}

dbGetQuery(con, sql) -> datosy
x <- as.numeric(datosx$RespuestaTexto)
y <- as.numeric(datosy$RespuestaTexto)
xtitulo <- datosx$Texto
ytitulo <- datosy$Texto
nom <- paste('../Datos/img/grafCorr_',metodo,idP1,idP2,'.png',sep='')
png(file=nom)
plot(x, y, main=paste0(xtitulo[1]," vs ",ytitulo[1], " (cor= ", formatC(cor(x,y,method=metodo), 3, format="f"),")"), xlab=xtitulo[1], ylab=ytitulo[1])
dev.off()
dbDisconnect(con)