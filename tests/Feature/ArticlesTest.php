<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function testShowAllEvents()
    {
        // 3 parts

        // 1) Preparo el test
        // 2) Executo el codi que vull provar
        // 3) Comprovo: assert

        $articles = factory(Article::class,50)->create();

        $response = $this->get('/articles');
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('list_article');
        // TODO Contar que hi ha 50 al resultat

        foreach ($articles as $article) {
            $response->assertSeeText($article->title);
            $response->assertSeeText($article->title);
        }
    }

    /**
     * @group todo
     */
    public function testShowAnArticle()
    {
        // Preparo
        $article = factory(Article::class)->create();
        // Executo
        $response = $this->get('/articles/'.$article->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('show_article');
        $response->assertViewHas('article');

        // assertSeeText() -> mira si apareix el text que li passes, a la web
        $response->assertSeeText($article->title);
        $response->assertSeeText($article->title);
        $response->assertSeeText('Article');
    }

    /**
     * @group todo
     */
    public function testNotShowAnArticle()
    {
        // Executo
        $response = $this->get('/articles/999999');
        // Comprovo
        $response->assertStatus(404);
    }

    //laravel eloquent: retrieving models

    public function testShowCreateArticleForm()
    {
        // Preparo
        // Executo
        $response = $this->get('/articles/create');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('create_article');
        $response->assertSeeText('Create Article');
    }

    public function testShowEditArticleForm()
    {
        // Preparo
        // Executo
        $response = $this->get('/articles/edit');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('edit_article');
        $response->assertSeeText('Edit Article');
    }

    public function testStoreArticleForm()
    {
        // Preparo
        $article = factory(Article::class)->make();
        // Executo
        $response = $this->post('/articles',[
            'title' => $article->title,
            'description' => $article->description,
        ]);
        // Comprovo
        $response->assertStatus(200);
        $response->assertRedirect('articles/create');
        $response->assertSeeText('Created ok!');

//        $this->assertDatabaseHas('articles',[
//            'title' => $article->title,
//            'description' => $article->description,
//        ]);
    }

//    public function testUpdateEventForm()
//    {
//        // Preparo
//        $event = factory(Event::class)->create();
//        // Executo
//        $newEvent = factory(Event::class)->make();
//        $response = $this->patch('/events/' . $event->id,[
//            'name' => $newEvent->name,
//            'description' => $newEvent->description,
//        ]);
//        // Comprovo
//        $response->assertStatus(200);
//        $response->assertRedirect('events/create');
//        $response->assertSeeText('Edited ok!');
//
//        $this->assertDatabaseHas('events',[
//            'id' =>  $event->id,
//            'name' => $newEvent->name,
//            'description' => $newEvent->description,
//        ]);
//
//        $this->assertDatabaseMissing('events',[
//            'id' =>  $event->id,
//            'name' => $event->name,
//            'description' => $event->description,
//        ]);
//    }

//    public function testDeleteEvent()
//    {
//        // Preparo
//        $event = factory(Event::class)->create();
//        // Executo
//        $response = $this->delete('/events/' . $event->id);
//        // Comprovo
//        //$response->assertStatus(200);
//        $response->assertRedirect('events');
//        $response->assertSeeText('Deleted ok!');
//
//        $this->assertDatabaseMissing('events', [
//            'name' => $event->name,
//            'description' => $event->description,
//        ]);
//    }
}
