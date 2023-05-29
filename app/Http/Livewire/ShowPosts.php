<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPosts extends Component {

    public $text;
    public $search;

    public $sort = 'id';
    public $direction = 'asc';

    public function render() {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->get();

        return view('livewire.show-posts', [
            'posts' => $posts,
        ]);
    }

    /**
     * 
     */
    public function order($field) {
        if ($this->sort == $field) {

            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
            
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }
}
