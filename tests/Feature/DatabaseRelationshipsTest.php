<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Console;
use App\Models\Game;
use App\Models\MaintenanceLog;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalItem;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_verifies_one_to_one_user_and_user_profile_relationship()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->profile->is($profile));
        $this->assertTrue($profile->user->is($user));
    }

    /** @test */
    public function it_verifies_one_to_many_category_and_consoles_relationship()
    {
        $category = Category::factory()->create();
        $console1 = Console::factory()->create(['category_id' => $category->id]);
        $console2 = Console::factory()->create(['category_id' => $category->id]);

        $this->assertCount(2, $category->consoles);
        $this->assertTrue($console1->category->is($category));
        $this->assertTrue($console2->category->is($category));
    }

    /** @test */
    public function it_verifies_many_to_many_console_and_games_relationship_with_pivot_data()
    {
        $console = Console::factory()->create();
        $game = Game::factory()->create();

        $console->games()->attach($game->id, [
            'installed_at' => now(),
            'storage_size_gb' => 85,
        ]);

        $this->assertTrue($console->games->contains($game));
        $this->assertEquals(85, $console->games->first()->pivot->storage_size_gb);
        $this->assertTrue($game->consoles->contains($console));
    }

    /** @test */
    public function it_verifies_one_to_many_user_and_rentals_relationship()
    {
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->rentals);
        $this->assertTrue($rental->user->is($user));
    }

    /** @test */
    public function it_verifies_many_to_many_rental_and_consoles_relationship()
    {
        $rental = Rental::factory()->create();
        $console = Console::factory()->create();

        RentalItem::factory()->create([
            'rental_id' => $rental->id,
            'console_id' => $console->id,
            'duration_days' => 2,
            'daily_rate_snapshot' => 75000.00,
            'subtotal' => 150000.00,
        ]);

        $this->assertTrue($rental->consoles->contains($console));
        $this->assertEquals(150000.00, $rental->consoles->first()->pivot->subtotal);
    }

    /** @test */
    public function it_verifies_one_to_one_rental_and_payment_relationship()
    {
        $rental = Rental::factory()->create();
        $payment = Payment::factory()->create(['rental_id' => $rental->id]);

        $this->assertTrue($rental->payment->is($payment));
        $this->assertTrue($payment->rental->is($rental));
    }

    /** @test */
    public function it_verifies_has_many_through_user_to_payments_relationship()
    {
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['user_id' => $user->id]);
        $payment = Payment::factory()->create(['rental_id' => $rental->id]);

        $this->assertCount(1, $user->payments);
        $this->assertTrue($user->payments->first()->is($payment));
    }

    /** @test */
    public function it_verifies_has_many_through_category_to_rental_items_relationship()
    {
        $category = Category::factory()->create();
        $console = Console::factory()->create(['category_id' => $category->id]);
        $rentalItem = RentalItem::factory()->create(['console_id' => $console->id]);

        $this->assertCount(1, $category->rentalItems);
        $this->assertTrue($category->rentalItems->first()->is($rentalItem));
    }

    /** @test */
    public function it_verifies_one_to_many_console_and_maintenance_logs_relationship()
    {
        $console = Console::factory()->create();
        $log = MaintenanceLog::factory()->create(['console_id' => $console->id]);

        $this->assertCount(1, $console->maintenanceLogs);
        $this->assertTrue($log->console->is($console));
    }
}
