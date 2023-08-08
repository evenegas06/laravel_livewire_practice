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
    public $text, $search, $image, $now;

    public $open        = false;
    public $is_ready    = false;

    public $sort        = 'id';
    public $direction   = 'desc';

    public $amount      = 10;

    /**
     * Events to listen.
     */
    protected $listeners = ['render', 'delete'];

    /**
     * Show options into url.
     */
    protected $queryString  = [
        'amount' => [
            'except' => '10',
        ],
        'sort' => [
            'except' => 'id',
        ],
        'direction' => [
            'except' => 'desc',
        ],
        'search' => [
            'except' => '',
        ],
    ];

    /**
     * Validation rules.
     */
    protected $rules = [
        'post.title'    => 'required',
        'post.content'  => 'required',
    ];

    /**
     * Like a constructor.
     */
    public function mount() {
        $this->now  = now();
        $this->post = new Post();
    }

    /**
     * The function is executed every time 
     * the value in the "search" property changes.
     */
    public function updatingSearch() {
        $this->resetPage();
    }

    /**
     * Render component.
     */
    public function render() {
        $posts = [];

        if ($this->is_ready) {
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->amount);
        }

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

    /**
     * Execute function when posts are load.
     */
    public function loadPost() {
        $this->is_ready = true;
    }

    /**
     * Delete post from database.
     */
    public function delete(Post $post) {
        $post->delete();
    }
}
