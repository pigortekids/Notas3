from mpi4py import MPI

comm = MPI.COMM_WORLD
size = comm.Get_size()
rank = comm.Get_rank()

if rank > 0:
    req  = comm.irecv( source = rank - 1 , tag = rank - 1 )
    data = req.wait()
    print("estou no rank {0} recebento o valor {1}".format(rank, data))
    
if rank < size - 1:
    data = { 'rank' : rank }
    req = comm.isend( data , dest = rank + 1 , tag = rank )
    req.wait()