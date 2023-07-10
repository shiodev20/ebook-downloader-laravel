<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\GenreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    private $genreRepository;

    public function __construct(GenreRepository $genreRepository) {
        $this->middleware(['auth', 'admin']);
        $this->genreRepository = $genreRepository;
    }

    public function index() {
        $genres = $this->genreRepository->getAll();

        return view('admin.genres.index', compact([
            'genres',
        ]));
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make(
                $request->all(),
                [ 'genre' => 'required' ],
                [ 'genre.required' => 'Vui lòng nhập tên thể loại' ]
            );
    
            if($validator->fails()) {
                return [
                    'status' => false,
                    'messages' => $validator->messages()
                ];
            }
    
            $genre = [
                'name' => $request->genre
            ];
    
            $result = $this->genreRepository->add($genre);
    
            return [
                'status' => true,
            ];

        } catch (\Throwable $th) {
            
        }
    }

    public function search(Request $request) {
        $name = $request->query('genre');

        $data = $this->genreRepository->find([
            [ 'name', 'like', '%'.$name.'%' ],
        ]);

        $genres = [];

        foreach ($data as $item) {
            $genre = [
                'id' => $item->id,
                'name' => $item->name,
                'book_count' => $item->books->count()
            ];

            array_push($genres, $genre);
        }

        return [
            'status' => true,
            'result' => [
                'genres' => $genres
            ],
        ];
    }

}
