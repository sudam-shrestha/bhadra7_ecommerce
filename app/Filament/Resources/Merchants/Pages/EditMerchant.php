<?php

namespace App\Filament\Resources\Merchants\Pages;

use App\Filament\Resources\Merchants\MerchantResource;
use App\Mail\MerchantApproval;
use App\Models\Merchant;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Override;

class EditMerchant extends EditRecord
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] === 'approve' && $this->record->status !== 'approve') {
            $password = rand(100000, 999999);
            $data['password'] = $password;
            $merchant = Merchant::where('email', $data['email'])->first();
            try {
                Mail::to($data['email'])->send(new MerchantApproval($merchant, $password));
            } catch (\Throwable $e) {
                report($e);
                Log::error($e);
            }
        }
        return parent::mutateFormDataBeforeSave($data);
    }
}
