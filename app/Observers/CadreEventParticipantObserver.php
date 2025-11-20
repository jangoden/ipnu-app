<?php

namespace App\Observers;

use App\Models\CadreEventParticipant;

class CadreEventParticipantObserver
{
    /**
     * Handle the CadreEventParticipant "created" event.
     */
    public function created(CadreEventParticipant $cadreEventParticipant): void
    {
        //
    }

    /**
     * Handle the CadreEventParticipant "updated" event.
     */
    public function updated(CadreEventParticipant $cadreEventParticipant): void
    {
        if ($cadreEventParticipant->isDirty('status') && $cadreEventParticipant->status === 'graduated') {
            $member = $cadreEventParticipant->member;
            $event = $cadreEventParticipant->cadreEvent;

            if ($member && $event) {
                $newGrade = null;
                switch ($event->type) {
                    case 'makesta':
                        $newGrade = 'kader_makesta';
                        break;
                    case 'lakmud':
                        $newGrade = 'kader_lakmud';
                        break;
                    case 'lakut':
                        $newGrade = 'kader_lakut';
                        break;
                }

                if ($newGrade) {
                    // To prevent re-triggering events, we can use updateQuietly if available
                    // or just be careful with the logic flow.
                    // For now, a direct update is fine.
                    $member->grade = $newGrade;
                    $member->save();
                }
            }
        }
    }

    /**
     * Handle the CadreEventParticipant "deleted" event.
     */
    public function deleted(CadreEventParticipant $cadreEventParticipant): void
    {
        //
    }

    /**
     * Handle the CadreEventParticipant "restored" event.
     */
    public function restored(CadreEventParticipant $cadreEventParticipant): void
    {
        //
    }

    /**
     * Handle the CadreEventParticipant "force deleted" event.
     */
    public function forceDeleted(CadreEventParticipant $cadreEventParticipant): void
    {
        //
    }
}
