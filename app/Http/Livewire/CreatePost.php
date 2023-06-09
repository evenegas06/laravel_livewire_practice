<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component {

    public $open = false;
    public $title;
    public $content;

    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required|min:20'
    ];

    /**
     * Render component.
     */
    public function render() {
        return view('livewire.create-post');
    }

    /**
     * Validation in Real Time
     */
    public function updated($property_name) {
        $this->validateOnly($property_name);
    }

    /**
     * Create a new Post and save in database.
     */
    public function save() {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);

        $this->reset(['open', 'title', 'content']);

        $this->emit('render');
        $this->emit('alert', 'Post creado con éxito');
    }
}
