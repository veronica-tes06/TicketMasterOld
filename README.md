# TicketMaster
Engineering Project

### Set up and Building with Jenkins:
+ Edit the connect.php file to include the right port (if localhost just leave out port)  
    ```` $dsn = 'mysql:host=localhost;port=3307;dbname=ticketmaster'; ````
+ and your my.ini on the Xampp Controller to match the port.
    ````
        # The following options will be passed to all MySQL clients
        [client]
        # password       = your_password 
        port=3307
        socket="C:/xampp/mysql/mysql.sock"
        
        
        # Here follows entries for some specific programs 
        
        # The MySQL server
        default-character-set=utf8mb4
        [mysqld]
        port=3307
    ````
