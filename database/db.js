const mysql = require('mysql');
const env = require('dotenv').config();

const conn = mysql.createConnection({
    host: "localhost",
    user: "root",
    database: "dbprog"
    // database: "dbshopp"
  });


  /*
  conn.connect((err) => {
    if (err) {
      console.error('Error connecting to MySQL database:', err);
      return;
    }
    console.log('Connected to MySQL database!');
  });
  
*/



// conn.query('SELECT * FROM food', function(err, foodData){
//   //console.log("Query successful!", foodData);
// });


module.exports = conn;