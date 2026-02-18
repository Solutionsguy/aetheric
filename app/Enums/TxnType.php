<?php

namespace App\Enums;

enum TxnType: string
{
    case AdsViewed = 'ads_viewed';
    case AdsPosted = 'ads_posted';
    case Deposit = 'deposit';
    case Subtract = 'subtract';
    case ManualDeposit = 'manual_deposit';
    case Referral = 'referral';
    case SignupBonus = 'signup_bonus';
    case Withdraw = 'withdraw';
    case WithdrawAuto = 'withdraw_auto';
    case ReceivedMoney = 'received_money';
    case Refund = 'refund';
    case FundTransfer = 'fund_transfer';
    case PlanPurchased = 'plan_purchased';
}
