<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component {

    use WithFileUploads;

    public $open = false;
    public $title;
    public $content;
    public $image;
    public $now;

    /**
     * Validation rules.
     */
    protected $rules = [
        'title'     => 'required|max:10',
        'content'   => 'required|min:20',
        'image'     => 'required|image|max:2040'
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

        $image = $this->image->store('public/posts');

        Post::create([
            'title'     => $this->title,
            'content'   => $this->content,
            'image'     => $image
        ]);

        $this->reset(['open', 'title', 'content', 'image']);
        
        $this->image = null;
        $this->now = now();

        $this->emit('render');
        $this->emit('alert', 'Post creado con éxito');
    }
}
