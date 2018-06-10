// clang -std=c11 -Wall like_cat.c -o cata
#define _GNU_SOURCE

#include <stdio.h>
#include <assert.h>
#include <stdlib.h>
#include <string.h>


int main(void)
{
    char *line = NULL;
    size_t len = 0;
    size_t nread;

    if ((nread = getline(&line, &len, stdin)) != -1) {
        const char * const pass = "timctf";
        if (strncmp(pass, line, strlen(pass)) != 0) {
            puts("Go away! Our secret password is 'timctf', not whatever you've written there");

            free(line);
            line = NULL;
			
            return EXIT_FAILURE;
        }
    } else {
        perror("You didn't enter our secret password 'timctf'...");

        free(line);
        line = NULL;

        return EXIT_FAILURE;
    }
    free(line);
    line = NULL;
    
    FILE *file = fopen("/flag2", "r");
    assert(file != NULL);
    
    int c;
    while ((c = (char)fgetc(file)) != EOF) {
        printf("%c", c);
    }

    fclose(file);
    
    return EXIT_SUCCESS;
}
