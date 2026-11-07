
#include <stdio.h>
#include <string.h>

int main()
{
    char line[512];
    int line_number = 1;
    int error_count = 0;

    FILE *file = fopen("server.log", "r");

    if (file == NULL)
    {
        printf("Cannot open log file!\n");
        return 1;
    }

    printf("Searching for errors...\n\n");

    while (fgets(line, sizeof(line), file) != NULL)
    {
        if (strstr(line, "ERROR") != NULL ||
            strstr(line, "WARNING") != NULL)
        {
            error_count++;

            printf("Line %d: %s", line_number, line);
        }

        line_number++;
    }

    fclose(file);

    printf("\n-------------------------\n");
    printf("Total alerts found: %d\n", error_count);

    return 0;
}
