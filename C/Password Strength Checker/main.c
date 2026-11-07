
#include <stdio.h>
#include <string.h>
#include <ctype.h>
#include <stdbool.h>

#define MAX_LENGTH 100

int check_password(const char *password)
{
    bool upper = false, lower = false;
    bool digit = false, special = false;

    int length = strlen(password);
    int score = 0;

    for (int i = 0; i < length; i++)
    {
        unsigned char ch = (unsigned char)password[i];

        if (isupper(ch))
            upper = true;
        else if (islower(ch))
            lower = true;
        else if (isdigit(ch))
            digit = true;
        else if (ispunct(ch))
            special = true;
    }

    if (length >= 8) score++;
    if (length >= 12) score++;
    if (upper) score++;
    if (lower) score++;
    if (digit) score++;
    if (special) score++;

    return score;
}

int main(void)
{
    char password[MAX_LENGTH];

    printf("=== Password Strength Checker ===\n");
    printf("Enter password: ");

    if (fgets(password, sizeof(password), stdin) == NULL)
        return 1;

    password[strcspn(password, "\n")] = '\0';

    if (strlen(password) == 0)
    {
        printf("Password cannot be empty!\n");
        return 1;
    }

    if (strchr(password, '\n') == NULL &&
        strlen(password) == MAX_LENGTH - 1)
    {
        int ch;
        while ((ch = getchar()) != '\n' && ch != EOF);
        printf("Password is too long!\n");
        return 1;
    }

    int score = check_password(password);

    printf("\nPassword Score: %d/6\n", score);

    if (score <= 2)
        printf("Strength: WEAK\n");
    else if (score <= 4)
        printf("Strength: MEDIUM\n");
    else
        printf("Strength: STRONG\n");

    return 0;
}
