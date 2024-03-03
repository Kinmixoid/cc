The project contains all necessary migrations and seeds to set up a working database sample.
After `composer install`, `npm install`, `php artisan migrate`, `php artisan db:seed` and `npm run build` the project
should be ready to run. 

The booking system is available at `/` and the admin panel at `/admin` with username `test@example.com` and password 
`password`.




If we can assume that the current website is built in Laravel, then we can certainly continue to use it for this 
project. Using Laravel would allow us to leverage our existing expertise and extend the functionality of the current 
website without significant changes to the maintenance. Laravel's extensive ecosystem provides ready-made solutions for 
many common problems, thus expediting the development process. The customer journey through the process of booking an 
appointment can be implemented as a Livewire component. This will ensure a fluid user experience while allowing seamless 
integration into the existing codebase. For the management of appointments, we could use Filament; it is a solid base 
for rapid development of basic CRUD interfaces as well as being extensible enough for further requirements that might 
be discovered during development.

The database schema consists of only three tables: appointments, appointment_types, and customers. Apart from primary 
indices on id columns, we would require indices for date, status, and appointment_type_id columns in the appointments 
table. We currently keep the relationship between customers and appointments as one-to-one; there is no need for an 
index on the customer_id field in the appointments table as we always go from appointment to customer information. If 
this ever changes, we'll need to add an index for the customer_id field.

For the customer journey, we use Livewire, which, under the hood, uses checksums to guard against CSRF attacks. 
Additional security measures would mainly include protection against spam and DDoS attacks using CAPTCHA. For the 
appointment management system, we use Filament that relies on Laravel's robust authentication service. Keeping Filament, 
Laravel, PHP, MySQL, and the rest of the server software updated should provide robust security for this application.

The main performance bottleneck in this application will be database interactions. This is why it is crucial to maintain 
relevant indices. Current migrations contain all the indices necessary for the proper operation of the customer journey. 
However, some of the filters, sorts, and searches in the admin panel do those operations on un-indexed columns. 
Depending on the use cases and the amount of data, this could be of concern. Adding additional indices would improve the 
performance of those operations, however, they will increase memory usage as well as slowing down insert and update 
operations.
