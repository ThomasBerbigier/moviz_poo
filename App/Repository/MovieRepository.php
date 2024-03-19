<?php

namespace App\Repository;
use App\Entity\Movie;

class MovieRepository extends Repository
{
    public function findOneById(int $id): Movie|bool
    {
        $query = $this->pdo->prepare("SELECT * FROM movie WHERE id = :id");
        $query->bindParam(':id', $id, $this->pdo::PARAM_STR);
        $query->execute();
        $movieData = $query->fetch($this->pdo::FETCH_ASSOC);
        if ($movieData) {
            return Movie::createAndHydrate($movieData);
        } else {
            return false;
        }
    }

    public function findAll(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM movie");
        $query->execute();
        $movies = $query->fetchAll($this->pdo::FETCH_ASSOC);

        $moviesArray = [];

        if ($movies) {
            foreach ($movies as $movie) {
                $moviesArray[] = Movie::createAndHydrate($movie);
            }
        }
        return $moviesArray;
    }
}