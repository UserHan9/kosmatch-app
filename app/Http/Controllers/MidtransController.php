<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    /**
     * Membuat Snap Token.
     */
    public function createSnapToken(Booking $booking)
    {
        abort_unless(
            $booking->user_id === auth()->id(),
            403
        );

        if ($booking->snap_token) {
            return response()->json([
                'snap_token' => $booking->snap_token,
            ]);
        }

        Config::$serverKey = config('services.midtrans.server_key');

        Config::$isProduction = config(
            'services.midtrans.is_production'
        );

        Config::$isSanitized = true;

        Config::$is3ds = true;

        $booking->load('user', 'room.kost');

        $params = [

            'transaction_details' => [
                'order_id' => $booking->order_id,
                'gross_amount' => (int) $booking->total_price,
            ],

            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],

            'item_details' => [
                [
                    'id' => 'ROOM-' . $booking->room_id,

                    'price' => (int) $booking->total_price,

                    'quantity' => 1,

                    'name' =>
                        'Booking Kamar ' .
                        $booking->room->room_number .
                        ' - ' .
                        $booking->room->kost->name,
                ],
            ],
        ];

        try {

            $snapToken = Snap::getSnapToken($params);

            $booking->update([
                'snap_token' => $snapToken,
            ]);

            return response()->json([
                'snap_token' => $snapToken,
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Midtrans Snap Token Error',
                [
                    'booking_id' => $booking->id,
                    'message' => $e->getMessage(),
                ]
            );

            return response()->json([
                'message' =>
                    'Gagal membuat pembayaran Midtrans.',
            ], 500);
        }
    }


   
    public function notification(Request $request)
    {
        Config::$serverKey = config(
            'services.midtrans.server_key'
        );

        Config::$isProduction = config(
            'services.midtrans.is_production'
        );

        Config::$isSanitized = true;

        Config::$is3ds = true;

        try {

            $notification = new \Midtrans\Notification();

            $orderId =
                $notification->order_id;

            $transactionStatus =
                $notification->transaction_status;

            $fraudStatus =
                $notification->fraud_status;

            $booking = Booking::where(
                'order_id',
                $orderId
            )->first();

            if (!$booking) {

                return response()->json([
                    'message' =>
                        'Booking tidak ditemukan.',
                ], 404);
            }



            if (
                $transactionStatus === 'settlement'
                ||
                (
                    $transactionStatus === 'capture'
                    &&
                    $fraudStatus === 'accept'
                )
            ) {

                $booking->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'transaction_id' =>
                        $notification->transaction_id,
                    'payment_type' =>
                        $notification->payment_type,
                    'paid_at' => now(),
                ]);
            }



            elseif (
                $transactionStatus === 'pending'
            ) {

                $booking->update([
                    'payment_status' => 'pending',
                    'transaction_id' =>
                        $notification->transaction_id,
                    'payment_type' =>
                        $notification->payment_type,
                ]);
            }


            /*
             * EXPIRED
             */
            elseif (
                $transactionStatus === 'expire'
            ) {

                $booking->update([
                    'payment_status' => 'expired',
                    'status' => 'cancelled',
                ]);
            }


           
            elseif (
                in_array(
                    $transactionStatus,
                    [
                        'deny',
                        'cancel',
                    ]
                )
            ) {

                $booking->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }


            Log::info(
                'Midtrans Notification',
                [
                    'order_id' => $orderId,
                    'transaction_status' =>
                        $transactionStatus,
                ]
            );

            return response()->json([
                'message' => 'OK',
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Midtrans Notification Error',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return response()->json([
                'message' => 'Notification error.',
            ], 500);
        }
    }
}