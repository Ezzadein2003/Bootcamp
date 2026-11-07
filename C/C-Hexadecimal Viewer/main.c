
#include <stdio.h>
#include <ctype.h>

#define BUFFER_SIZE 16

void display_hex_view(FILE *file)
{
    unsigned char data[BUFFER_SIZE];
    size_t count;

    while ((count = fread(data, 1, BUFFER_SIZE, file)) > 0)
    {
        // Display hexadecimal values
        for (size_t i = 0; i < count; i++)
        {
            printf("%02X ", data[i]);
        }

        // Align the text column
        for (size_t i = count; i < BUFFER_SIZE; i++)
        {
            printf("   ");
        }

        printf(" | ");

        // Display readable characters
        for (size_t i = 0; i < count; i++)
        {
            if (isprint(data[i]))
                printf("%c", data[i]);
            else
                printf(".");
        }

        printf("\n");
    }
}

int main(int argc, char *argv[])
{
    FILE *file;

    if (argc != 2)
    {
        printf("Usage: %s <filename>\n", argv[0]);
        return 1;
    }

    file = fopen(argv[1], "rb");

    if (file == NULL)
    {
        perror("File opening failed");
        return 1;
    }

    printf("\n------ HEXADECIMAL VIEWER ------\n\n");

    display_hex_view(file);

    fclose(file);

    return 0;
}
