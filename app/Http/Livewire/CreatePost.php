<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component {

    public $open = false;
    public $title;
    public $content;

    /**
     * Render component.
     */
    public function render() {
        return view('livewire.create-post');
    }
    
    /**
     * Create a new Post and save in database.
     */
    public function save() {
        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        $this->reset(['open', 'title', 'content']);
        $this->emit('render');
        $this->emit('alert', 'Post creado con éxito');
    }
}
