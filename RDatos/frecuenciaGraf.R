# freceuncia.R : Grafico Distribucion de Frecuencia

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP <- args[1]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT (CASE WHEN LENGTH(O.Texto) > 9 THEN O.idOpcion ELSE O.Texto END) AS Texto, (SELECT COUNT(*) FROM respuestaspreguntas R WHERE R.idOpcion = O.idOpcion) AS Cantidad FROM opcionespreguntas O where O.idPregunta = ",idP,sep='')
datos <- dbGetQuery(con, sql)
a <- table(datos)
tot <- sum(datos$Cantidad)
r <- datos$Cantidad / tot
columnas <- unique(datos$Texto)
old = options(digits=4) 
r <- r * 100
nom <- paste('../Datos/img/graFrec',idP,'.png',sep='')
png(file=nom)
if(length(datos$Texto) > 6){
    barplot(r,names.arg=datos$Texto,col = rainbow(length(datos$Texto)),xlim=c(0,100),cex.names=0.8,axes=TRUE,srt=45,horiz=TRUE)
    legend("topright", columnas, cex=0.8,bty="n", fill=rainbow(length(datos$Texto)))
}else
{ 
    barplot(r,names.arg=datos$Texto,col = rainbow(length(datos$Texto)),cex.names=0.8,srt=45,ylim=c(0,100))
    legend("topright", columnas, cex=0.8,bty="n", fill=rainbow(length(datos$Texto)))
}

dev.off()
dbDisconnect(con)