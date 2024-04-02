<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist() 
    {
        $this->withSession([
            "user" => "esnur",
            "todolist" => [
                [
                "id" => "1",
                "todo" => "makan"
                ],
                [
                    "id" => "2",
                    "todo" => "minum"
                ]
            ]
            ])->get('/todolist')
                ->assertSeeText("1")
                ->assertSeeText("makan")
                ->assertSeeText("2")
                ->assertSeeText("minum");
    }

    public function testAddTodoFailed() 
    {
        $this->withSession([
            "user" => "esnur"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required!");
    }

    public function testAddTodoSucces() 
    {
        $this->withSession([
            "user" => "esnur"
        ])->post("/todolist", [
            "todo" => "esnur"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            "user" => "esnur",
            "todolist" => [
                [
                "id" => "1",
                "todo" => "makan"
                ],
                [
                    "id" => "2",
                    "todo" => "minum"
                ]
            ]
            ])->post("/todolist/1/delete")
                    ->assertRedirect("/todolist");
    }
}
