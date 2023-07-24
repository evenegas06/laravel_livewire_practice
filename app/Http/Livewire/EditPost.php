<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component {

    use WithFileUploads;

    public Post $post;
    public $open = false;
    public $image;
    public $now;

    /**
     * Validation rules.
     */
    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    /**
     * Like a constructor.
     */
    // public function mount(Post $post) {
    //     $this->post = $post;
    // }

    /**
     * Render component.
     */
    public function render() {
        return view('livewire.edit-post');
    }

    /**
     * Update post in database.
     */
    public function save() {
        $this->validate();

        if ($this->image) {
            Storage::delete($this->post->image);

            $this->post->image = $this->image->store('public/posts');
        }

        $this->post->save();

        $this->reset(['open', 'image']);
        $this->now = now();

        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizó correctamente. 🙂');
    }
}
