<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * Testing landing page.
     *
     * @return void
     */

    public function test_download_page()
    {
        $response = $this->get('/download-csv');

        $response->assertStatus(200);
    }

    /**
     * Testing landing page.
     *
     * @return void
     */

     public function test_landing_page()
     {
         $response = $this->get('/');

         $response->assertStatus(200);
     }
}
