<?php
    echo "<table style='border: solid 1px black;'>";
    echo "<tr> <th>User ID</th> <th>User First Name</th> <th>User Last Name</th> <th>User Email</th> </tr>";

    class UsersTableRows extends RecursiveIteratorIterator {
        function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }

        function current() {
            return "<td style='width:170px;border:1px solid black;'>" . parent::current(). "</td>";
        }

        function beginChildren() {
            echo "<tr>";
        }

        function endChildren() {
            echo "</tr>" . "\n";
        }
    }

    try {
    // check if user is an admin
    if($personType == 3){
        // prepare sql query to get all user information
        $q = $conn->prepare("SELECT personID, personFName, personLName, email FROM Person");
    }
    
    // No placeholder values to bind
   
    // execute the query
    $q->execute();

    // set the resulting array to associative
    $result = $q->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new UsersTableRows(new RecursiveArrayIterator($q->fetchAll())) as $k=>$v) {
        echo $v;
    }
    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
    echo "</table>";
?>