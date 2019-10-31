from mpi4py import MPI

comm = MPI.COMM_WORLD
size = comm.Get_size()
rank = comm.Get_rank()


tamanho = 10
for i in range(rank, tamanho, size):
    print("rank {0}, no i {1}".format(rank, i))

"""
if rank > 0:
    req  = comm.irecv( source = rank - 1 , tag = rank - 1 )
    data = req.wait()
    print("estou no rank {0} recebento o valor {1}".format(rank, data))
    
if rank < size - 1:
    data = { 'rank' : rank }
    req = comm.isend( data , dest = rank + 1 , tag = rank )
    req.wait()
"""