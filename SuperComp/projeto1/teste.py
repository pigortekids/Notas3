from mpi4py import MPI
import glob, os, shutil #mexer com arquivos
import sys

HDexterno = "H:/TCC/" #coloquei isso porque fica mudando o nome do diretorio
versao = "v9" #versão que esta sendo usada
pastaCoisas = HDexterno + "Coisas/" #pasta com arquivos com feriados e vencimentos
pastaArquivosDescompactados = HDexterno + "ArquivosDescompactados/" #pasta dos arquivos originais
pastaArquivosDescompactadosJaRodados = HDexterno + "ArquivosDescompactados/JaRodados/" #pasta dos arquivos originais ja rodados

comm = MPI.COMM_WORLD
size = comm.Get_size()
rank = comm.Get_rank()

qnt_arquivos = len([f for f in os.listdir(pastaArquivosDescompactados)if os.path.isfile(os.path.join(pastaArquivosDescompactados, f))])
qnt_arquivos = 15

divisoes = size
while (qnt_arquivos % divisoes ) > divisoes / 2:
    divisoes -= 1

if rank < size - 1:
    qnt_arquivos_para_rodar = int(qnt_arquivos / divisoes)
    comecar_em = rank * qnt_arquivos_para_rodar 
else:
    if divisoes != size:
        qnt_arquivos_para_rodar = (qnt_arquivos % divisoes)
        if qnt_arquivos_para_rodar == 0:
            req = comm.send( 1 , dest = 0 , tag = rank )
            sys.exit()
    else:
        qnt_arquivos_para_rodar = int(qnt_arquivos / divisoes) + (qnt_arquivos % divisoes)
    comecar_em = qnt_arquivos - qnt_arquivos_para_rodar
   
acabar_em = comecar_em + qnt_arquivos_para_rodar - 1

print("rank {0} comeca em {1} e acaba em {2}".format(rank, comecar_em, acabar_em))

if rank != 0:
    req = comm.send( 1 , dest = 0 , tag = rank )
else:
    for i in range(1, size):
        req  = comm.irecv( source = i , tag = i )
        data = req.wait()
        print("Mensagem do rank {0} recebida".format(i))