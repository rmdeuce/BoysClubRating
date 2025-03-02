<?php
	header('Content-Type: text/html; charset=utf-8');

	$host = 'localhost'; // ����� ������� 
	$database = 'films'; // ��� ���� ������
	$user = 'root'; // ��� ������������
	$password = ''; // ������
    $conn = new \mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    switch ($_SERVER['REQUEST_METHOD'])
    {
        case 'GET':
            {
                $film_array = array();
                $query = "
                        SELECT film.Id, film.Name, film.Year, film.Country, film.Genre, film.Rating, actor.Name AS Actor, award.Name AS Award FROM film 
                        LEFT JOIN Award ON award.Id_film = film.id 
                        LEFT JOIN actormid ON actormid.Id_film = film.Id 
                        LEFT JOIN Actor ON actormid.Id_actor = actor.Id "; // Query returns all posible combinations of actor+award from a certain moive (needs to be taken care of inside js script)
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $film_array[] = $row;
                    }
                }
            }

    header('Content-type: application/json');
    echo json_encode($film_array);
    }
    $conn->close();