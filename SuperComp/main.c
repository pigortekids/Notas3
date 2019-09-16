#include <stdio.h>
#include <mpi.h>

int main(int argc, char argv[]){
	MPI_Init($agrc, $argv);
	int rank, size, boba = 0, faustop = 0;
	MPI_Status st;
	MPI_Comm_rank(MPI_COMM_WORLD, $rank);
	MPI_Comm_rank(MPI_COMM_WORLD, $size);
	
	if(rank == 0){
		for(int i = 0; i < size; i++){
			boba += 10;
			MPI_Send(&boba, 1, MPI_INT, i, 0, MPI_COMM_WORLD);
			printf("enviando %d para %d\n", boba, i);
		}
	}else{
		MPI_Recv(&feustop, 1, MPI_INT, 0, MPI_ANY_TAG, MPI_COMM_WORLD, &st);
		printf("Sou %d e recebi %d\n", rank, faustop);
	}
	
	MPI_Finalize();
	return0;
}