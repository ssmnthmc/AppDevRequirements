using System;
using Microsoft.Data.Sqlite;

class Program
{
    static void Main()
    {
        SqliteConnection connection = new SqliteConnection("Data Source=orders.db");
        connection.Open();

        // create table
        SqliteCommand createTable = connection.CreateCommand();
        createTable.CommandText =
            "CREATE TABLE IF NOT EXISTS Orders (" +
            "Id INTEGER PRIMARY KEY AUTOINCREMENT, " +
            "Product TEXT, " +
            "Quantity INTEGER" +
            ");";
        createTable.ExecuteNonQuery();

        // app
        while (true)
        {
            Console.WriteLine("\n== ORDERING APP ==");
            Console.WriteLine("1. Add Order");
            Console.WriteLine("2. View Orders");
            Console.WriteLine("3. Update Orders");
            Console.WriteLine("4. Delete Orders");
            Console.WriteLine("5. Exit App");
            Console.Write("\nEnter a number: ");

            string input = Console.ReadLine();

            // add order
            if (input == "1")
            {
                Console.Write("\nProduct name: ");
                string product = Console.ReadLine();

                Console.Write("Quantity: ");
                int quantity = int.Parse(Console.ReadLine());

                SqliteCommand insert = connection.CreateCommand();
                insert.CommandText =
                    "INSERT INTO Orders (Product, Quantity) VALUES ('" +
                    product + "', " + quantity + ");";
                insert.ExecuteNonQuery();

                Console.WriteLine("\nOrder added.");
            }

            // view order
            else if (input == "2")
            {
                SqliteCommand select = connection.CreateCommand();
                select.CommandText = "SELECT * FROM Orders;";

                SqliteDataReader reader = select.ExecuteReader();

                Console.WriteLine();
                Console.WriteLine("ID   | Product                  | Quantity");
                Console.WriteLine("------------------------------------------");

                while (reader.Read())
                {
                    string id = reader.GetInt32(0).ToString().PadRight(4);
                    string product = reader.GetString(1).PadRight(20);
                    string quantity = reader.GetInt32(2).ToString().PadRight(8);

                    Console.WriteLine(id + "| " + product + "| " + quantity);
                }

                reader.Close();
            }


            // update order
            else if (input == "3")
            {
                Console.Write("Enter Order ID to update: ");
                int id = int.Parse(Console.ReadLine());

                Console.Write("New product name: ");
                string newProduct = Console.ReadLine();

                Console.Write("New quantity: ");
                int newQuantity = int.Parse(Console.ReadLine());

                SqliteCommand update = connection.CreateCommand();
                update.CommandText =
                    "UPDATE Orders SET Product = '" + newProduct +
                    "', Quantity = " + newQuantity +
                    " WHERE Id = " + id + ";";
                update.ExecuteNonQuery();

                Console.WriteLine("Order updated.");
            }

            // delete order
            else if (input == "4")
            {
                Console.Write("Enter Order ID to delete: ");
                int id = int.Parse(Console.ReadLine());

                SqliteCommand delete = connection.CreateCommand();
                delete.CommandText =
                    "DELETE FROM Orders WHERE Id = " + id + ";";
                delete.ExecuteNonQuery();

                Console.WriteLine("Order deleted.");
            }

            else if (input == "5")
            {
                break;
            }

            else
            {
                Console.WriteLine("Invalid input. Try again.");
            }
        }

        connection.Close();
    }
}
