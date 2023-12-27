# Restaurant Reservation System
Project allows users to create restaurants and make the reservations.

## Project Features
Main feature of the project is to allocate available restaurant tables for the reservation, when it is booked. This is achieved by filtering the available tables for the requested time, and then calculating the best-match tables (this is only a thing if restaurant have different size tables available) for the requested amount of people. 
Project also allows authenticated users (only seeder users are available, there is currently no registration due to the fact that reservation itself does not require authentication) to create new restaurants, with custom table sizes for future reservations. Authenticated users can also see restaurant list with ability to see all the future/past reservation for the restaurant.

## How to run the Project
1. Clone the repository.
2. Install dependencies with `./vendor/bin/sail npm install`.
3. Test data can be added with `./vendor/bin/sail artisan migrate --seed`.
4. Start Sail with `./vendor/bin/sail up`.
5. Start Vite with `./vendor/bin/sail npm run dev`.
 
## Technologies Used
- PHP v8.2
- Laravel v10.38
- Livewire v3.3
- Pest v2.29

## Challenges and Solutions
- Main challenge was to correctly select required amount of seats for the reservation. This was achieved with recursion, calculating how many guests needs to be seated, and either returning the table that matches the request, or remembering the largest available table and recursively calling the same calculation, passing the available tables without the one that was put aside. 
- Another challange was to inform user when there is no tables available for the requested reservation. This was achieved with Livewire component, which calls the repository and checks currently available tables each time user makes a change on reservation place, time or duration. 
  
## Future Improvements
- While testing, it was noticed that the table allocation function does not always selects optimal solution for the restaurant. For example, if there are 3 available tables (tabla A with 4 seats, table B with 6 seats and table C with 8 seats), a reservation for 10 guests will get tables A and C (largest table, and then lowest that completes the request). Optimal solution would be to alocate tables A and B for this reservation, and keep table C for future reservations, but this solution requires a lot of computing power for bigger restaurants (if, we say, restaurant have 30 tables, we would need to calculate every possible combination of the tables to find the best match). 
- Another issue for real-life scenario would be that not all the tables are placed near one another (in the previous example, table A might be on the North-West side of the restaurant, and table C on the South-East corner, which would make guests separated), so such calculation of matching the best seats would not be possible. Additional information on the restaurant create form, which would provide table location, could be included to know if they can be pushed together, or are placed near one another to be able to seat all the guests at the same place.
- Reservation edit form does not sound like a proper improvement, as allocated tables would have to be recalculated, and there is a possibility that all other tables are already booked for the time, but restaurant admin panel could have such ability, as it would require manual review of the edit request to be approved.
- Restaurant edit form would be a nice improvement, but also changing the table size could be challanging to make (if there are already reservations for the table, they would have to be relocated). Also deleting tables could possibly break future reservations, which should be also taken into consideration.
- Reservation cancellation would also be an improvement, if restaurant could not accommodate the people for various reasons. This feature should inform all the reservation guests about the cancellation, as all the emails are already provided.
- As it is possible for multiple users to make a reservation at the same restaurant for the same time, some sort of table lock could be introduced to prevent such situations.