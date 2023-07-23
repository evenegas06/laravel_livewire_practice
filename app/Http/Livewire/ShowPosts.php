<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component {
    use WithFileUploads;
    use WithPagination;

    public Post $post;
    public $text;
    public $search;
    public $image;
    public $now;
    
    public $open = false;
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = ['render'];

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    /**
     * Like a constructor.
     */
    public function mount() {
        $this->now = now();
        $this->post = new Post();
    }

    /**
     * Render component.
     */
    public function render() {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate(10);

        return view('livewire.show-posts', [
            'posts' => $posts,
        ]);
    }

    /**
     * Order field ascendent or descendent.
     * 
     * @param string $field
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

    /**
     * Edit post by id.
     * 
     * @param App\Models\Post
     */
    public function edit(Post $post) {
        $this->post = $post;
        $this->open = true;
    }

    /**
     * Update post on database.
     */
    public function update() {
        $this->validate();

        if ($this->image) {
            Storage::delete($this->post->image);

            $this->post->image = $this->image->store('public/posts');
        }

        $this->post->save();
        $this->reset(['open', 'image']);

        $this->now = now();
        $this->emit('alert', 'El post se actualizó correctamente. 🙂');
    }
}
