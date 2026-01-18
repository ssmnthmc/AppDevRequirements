//Salgado, Samantha Marion C. - Activity 1 - Simple C# Console Application
using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        List<string> tasks = new List<string>();

        while (true)
        {
            Console.WriteLine("\n=== TO-DO LIST ===");
            Console.WriteLine("1 - Add task");
            Console.WriteLine("2 - View tasks");
            Console.WriteLine("3 - Remove task");
            Console.WriteLine("4 - Exit");
            Console.Write("\nEnter a number: ");

            string choice = Console.ReadLine();

            if (choice == "1")
            {
                Console.Write("\nEnter task: ");
                tasks.Add(Console.ReadLine());
                Console.Write("\nTask Recorded!\n");
            }
            else if (choice == "2")
            {
                Console.Write("\nTask List: \n");
                for (int i = 0; i < tasks.Count; i++)
                {
                    Console.WriteLine($"{i + 1}. {tasks[i]}");
                }
            }
            else if (choice == "3")
            {
                Console.Write("\nEnter task number: ");
                int index = int.Parse(Console.ReadLine());
                tasks.RemoveAt(index - 1);
                Console.Write("\nTask Removed!\n");
            }
            else if (choice == "4")
            {
                break;
            }
        }
    }
}

