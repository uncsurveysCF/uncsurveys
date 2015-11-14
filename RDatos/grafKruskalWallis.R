# grafKruskalWallis.R : 

library(DBI)
library(RMySQL)

args <- commandArgs(TRUE) 
idP1 <- args[1]
idOp1 <- args[2]
idP2 <- args[3]
con <- dbConnect(RMySQL::MySQL(), username = "root", password = "", host = "localhost", dbname="uncsurveys")
sql <- paste("SELECT * FROM (SELECT O.Texto AS fila, C.Texto AS Columna, C.Ponderacion, R.idRespuesta FROM respuestaspreguntas R INNER JOIN opcionespreguntas O ON R.idOpcion = O.idOpcion INNER JOIN columnaspreguntas C ON R.idColumna = C.idColumna WHERE R.idOpcion = ",idOp1, " AND R.idPregunta = ",idP1,") P INNER JOIN (SELECT O.Texto AS grupos, R.idRespuesta FROM respuestaspreguntas R INNER JOIN opcionespreguntas O ON R.idOpcion = O.idOpcion WHERE R.idPregunta = ",idP2,") G ON P.idRespuesta = G.idRespuesta",sep='')
dbGetQuery(con, sql) -> datos
nom <- paste('../Datos/img/grafKruskalWallis_',idP1,idOp1,idP2,'.png',sep='')
png(file=nom)
leGrupos <- unique(datos$grupos)
barplot(table(datos$grupos,datos$Columna),col = rainbow(length(leGrupos)), beside=T,cex.names=0.7,legend.text=leGrupos ,args.legend=list(x=12,y=25,cex=0.8))
legend("topright", leGrupos, cex=0.6,bty="n", fill=rainbow(length(leGrupos)));
dev.off()
datosGr <- as.factor(datos$grupos)
pw <- kruskal.test(datos$Columna,datosGr) 
pw
dbDisconnect(con)