<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('posts');

        $response->assertSeeText('No Posts');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New Title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid Title',
            'content' => 'At least 10 characters.',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals(
            "The title must be at least 5 characters.",
            $messages['title'][0]
        );
        $this->assertEquals(
            "The content must be at least 10 characters.",
            $messages['content'][0]
        );
    }

    public function testUpdateValid()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);

        $params = [
            'title' => 'Updated Title',
            'content' => 'At least 10 characters.',
        ];

        $this->put("/posts/{$post->id}/", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post Updated!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Updated Title',
            'content' => 'At least 10 characters.',
        ]);

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New Title',
            'content' => "Hello World",
        ]);
    }

    public function testDeleteBlogPost()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New Title',
            'content' => "Hello World",
        ]);
    }

    private function createDummyBlogPost()
    {
        $post = new BlogPost();
        $post->title = "New Title";
        $post->content = "Hello World";
        $post->save();

        return $post;
    }
}
