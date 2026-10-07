<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Room;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_verifies_one_to_one_user_and_user_profile_relationship()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->profile->is($profile));
        $this->assertTrue($profile->user->is($user));
    }

    public function test_it_verifies_one_to_many_property_type_and_properties_relationship()
    {
        $type = PropertyType::factory()->create();
        $property = Property::factory()->create(['property_type_id' => $type->id]);

        $this->assertCount(1, $type->properties);
        $this->assertTrue($property->propertyType->is($type));
    }

    public function test_it_verifies_one_to_many_owner_user_and_properties_relationship()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $property = Property::factory()->create(['owner_id' => $owner->id]);

        $this->assertCount(1, $owner->ownedProperties);
        $this->assertTrue($property->owner->is($owner));
    }

    public function test_it_verifies_one_to_many_property_and_rooms_relationship()
    {
        $property = Property::factory()->create();
        $room1 = Room::factory()->create(['property_id' => $property->id]);
        $room2 = Room::factory()->create(['property_id' => $property->id]);

        $this->assertCount(2, $property->rooms);
        $this->assertTrue($room1->property->is($property));
        $this->assertTrue($room2->property->is($property));
    }

    public function test_it_verifies_many_to_many_room_and_facilities_relationship_with_pivot_data()
    {
        $room = Room::factory()->create();
        $facility = Facility::factory()->create();

        $room->facilities()->attach($facility->id, [
            'condition' => 'good',
            'installed_at' => now(),
        ]);

        $this->assertTrue($room->facilities->contains($facility));
        $this->assertEquals('good', $room->facilities->first()->pivot->condition);
        $this->assertTrue($facility->rooms->contains($room));
    }

    public function test_it_verifies_one_to_many_tenant_user_and_leases_relationship()
    {
        $tenant = User::factory()->create(['role' => 'tenant']);
        $lease = Lease::factory()->create(['tenant_id' => $tenant->id]);

        $this->assertCount(1, $tenant->leases);
        $this->assertTrue($lease->tenant->is($tenant));
    }

    public function test_it_verifies_one_to_many_lease_and_payments_relationship()
    {
        $lease = Lease::factory()->create();
        $payment = Payment::factory()->create(['lease_id' => $lease->id]);

        $this->assertCount(1, $lease->payments);
        $this->assertTrue($payment->lease->is($lease));
    }

    public function test_it_verifies_has_many_through_user_to_payments_relationship()
    {
        $tenant = User::factory()->create(['role' => 'tenant']);
        $lease = Lease::factory()->create(['tenant_id' => $tenant->id]);
        $payment = Payment::factory()->create(['lease_id' => $lease->id]);

        $this->assertCount(1, $tenant->payments);
        $this->assertTrue($tenant->payments->first()->is($payment));
    }

    public function test_it_verifies_has_many_through_property_to_leases_relationship()
    {
        $property = Property::factory()->create();
        $room = Room::factory()->create(['property_id' => $property->id]);
        $lease = Lease::factory()->create(['room_id' => $room->id]);

        $this->assertCount(1, $property->leases);
        $this->assertTrue($property->leases->first()->is($lease));
    }

    public function test_it_verifies_one_to_many_room_and_maintenance_requests_relationship()
    {
        $room = Room::factory()->create();
        $tenant = User::factory()->create(['role' => 'tenant']);
        $ticket = MaintenanceRequest::factory()->create([
            'room_id' => $room->id,
            'tenant_id' => $tenant->id,
        ]);

        $this->assertCount(1, $room->maintenanceRequests);
        $this->assertTrue($ticket->room->is($room));
        $this->assertTrue($ticket->tenant->is($tenant));
    }
}
