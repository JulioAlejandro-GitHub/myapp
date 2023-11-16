

const mysql = require('mysql2');
// create a new MySQL connection
const connection = mysql.createConnection({
  host: 'localhost',
  port     : '8889',
  user: 'root',
  password: 'root',
  database: 'GuardiaDigital'
});
// connect to the MySQL database
connection.connect((error) => {
  if (error) {
    console.error('Error connecting to MySQL database:', error);
  } else {
    console.log('Connected to MySQL database!');
  }
});
// close the MySQL connection
connection.end();