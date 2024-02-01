<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document_size = 30;
        $user_size = 3;
        $department_size = 5;

        $remarks = [
            "More RVs were seen in the storage lot than at the campground.",
            "Dan ate the clouds like cotton candy.",
            "That was how he came to win $1 million.",
            "The sign said there was road work ahead so he decided to speed up.",
            "He found rain fascinating yet unpleasant.",
            "Poison ivy grew through the fence they said was impenetrable.",
            "The elephant didn't want to talk about the person in the room.",
            "There is no better feeling than staring at a wall with closed eyes.",
            "People keep telling me orange but I still prefer pink.",
            "The father handed each child a roadmap at the beginning of the 2-day road trip and explained it was so they could find their way home.",
            "Getting up at dawn is for the birds.",
            "There's a message for you if you look up.",
            "8% of 25 is the same as 25% of 8 and one of them is much easier to do in your head.",
            "He dreamed of leaving his law firm to open a portable dog wash.",
            "Pink horses galloped across the sea.",
            "There was coal in his stocking and he was thrilled.",
            "The murder hornet was disappointed by the preconceived ideas people had of him.",
            "She works two jobs to make ends meet; at least, that was her reason for not having time to join us.",
            "Sometimes you have to just give up and win by cheating.",
            "A quiet house is nice until you are ordered to stay in it for months.",
            "I've never seen a more beautiful brandy glass filled with wine.",
            "The swirled lollipop had issues with the pop rock candy.",
            "Of course, she loves her pink bunny slippers.",
            "It dawned on her that others could make her happier, but only she could make herself happy.",
            "The balloons floated away along with all my hopes and dreams.",
            "She was the type of girl who wanted to live in a pink house.",
            "It's never been my responsibility to glaze the donuts.",
            "All you need to do is pick up the pen and begin.",
            "Edith could decide if she should paint her teeth or brush her nails.",
            "When transplanting seedlings, candied teapots will make the task easier."
        ];
        $remarks_size = count($remarks);

        for ($i= 1; $i <= $document_size; $i++)
        {
            $random_assign_counts = random_int(4,6); //Change this to decrease or increase assigns in each documents.
            for($j=1; $j <= $random_assign_counts; $j++)
            {
                $random_assignable_type = rand(1,2);
                if ($random_assignable_type == 1)
                {
                    $assignable = User::find(rand(1,$user_size));
                    $timestamps = Carbon::now()->subMonth()->addDays($j);
                    $assignable->documents()->attach($i,
                        [
                            'remarks'=>$remarks[rand(1,$remarks_size-1)],
                            'created_at' => $timestamps,
                            'updated_at' =>$timestamps,
                            'user_id'=>$assignable->id,
                        ]);
                }
                if ($random_assignable_type == 2)
                {
                    $assignable = Department::find(rand(1,$department_size));
                    $timestamps = Carbon::now()->subMonth()->addDays($j);
                    $assignable->documents()->attach($i,
                        [
                            'remarks'=>$remarks[rand(1,$remarks_size-1)],
                            'created_at' => $timestamps,
                            'updated_at' =>$timestamps,
                            'user_id'=>rand(1,$user_size),
                        ]);
                }
            }
        }
    }
}
