<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\Asset;
use App\Models\Content;
use App\Models\Radio;
use App\Repositories\PremiumPromotion;
use App\Repositories\Promotions\PromotionAbstract;
use App\Repositories\Promotions\PromotionAnswer;
use App\Repositories\Promotions\PromotionLink;
use App\Repositories\Promotions\PromotionTest;
use App\Repositories\Promotions\PromotionVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserRadioContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.radio-content.all', [
            'radio' => Radio::findOrFail(session('radio_id'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeContent = PromotionLink::getType();
        if (request()->has(PromotionTest::getType())) {
            $typeContent = PromotionTest::getType();
        } else if (request()->has(PromotionAnswer::getType())) {
            $typeContent = PromotionAnswer::getType();
        } else if (request()->has(PromotionVoucher::getType())) {
            $typeContent = PromotionVoucher::getType();
        }
        return view('user.radio-content.create', [
            'radio' => Radio::findOrFail(session('radio_id')),
            'typeContent' => $typeContent,
            'advertisers' => Advertiser::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'promKind' => 'required|in:' . implode(',', [PromotionAnswer::getType(), PromotionLink::getType(), PromotionTest::getType(), PromotionVoucher::getType()]),
                'text' => 'required|string',
                'image' => 'required|image|max:3000',
                'advertiserId' => 'nullable|exists:advertisers,id',
                'premiumName' => 'required_with:hasPremium|string',
                'premiumRule' => 'required_with:hasPremium|string',
                'premiumValidAt' => 'required_with:hasPremium|date|after_or_equal:today',
                'premiumRewardAmount' => 'nullable|numeric|min:1',
                'premiumWinMethod' => 'required_with:hasPremium|string|in:lottery,chronologic',
                'premiumLotteryAt' => 'required_if:premiumWinMethod,lottery|date|after_or_equal:today',
                'premiumRewardOnlyCorrect' => 'nullable|bool',
                'linkLabel' => 'required_if:promKind,' . PromotionLink::getType() . '|string',
                'linkUrl' => 'required_if:promKind,' . PromotionLink::getType() . '|url',
                'testAnswers' => 'required_if:promKind,' . PromotionTest::getType() . '|array',
                'testAnswers.*' => 'string',
                'testAnswersCorrectly' => 'nullable|array',
                'testAnswersCorrectly.*' => 'numeric',
                'answerLabel' => 'required_if:promKind,' . PromotionAnswer::getType() . '|string',
                'voucherLabel' => 'required_if:promKind,' . PromotionVoucher::getType() . '|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                '_cod' => 'radio-content/create/validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'radio-content/create/*',
                'errs' => [$e->getMessage()]
            ], 500);
        }

        try {
            $content = new Content();
            $content->id = Str::uuid()->toString();
            $content->radio_id = session('radio_id');
            $content->text = $data['text'];

            $content->promotion($this->handlePromotion($data, $content));

            $content->image_asset_id = Asset::createLocalFromUploadedFile($data['image'])->id;
            $content->save();
        } catch (\Throwable $e) {
            return response()->json([
                '_cod' => 'radio-content/create/*',
                'errs' => [$e->getMessage(), $e->getTrace()]
            ], 500);
        }

        try {
            if ($data['advertiserId']) {
                $content->advertisers()->attach($data['advertiserId']);
            }
        } catch (\Throwable $e) {
            $content->delete();
            return response()->json([
                '_cod' => 'radio-content/create/advertiserId/invalid',
            ], 422);
        }

        return response()->json([
            '_cod' => 'ok',
            'contentId' => $content->id
        ]);
    }

    public function handlePromotion(array $data, Content $content): PromotionAbstract
    {
        $promotionsClasses = [
            PromotionAnswer::getType() => PromotionAnswer::class,
            PromotionLink::getType() => PromotionLink::class,
            PromotionTest::getType() => PromotionTest::class,
            PromotionVoucher::getType() => PromotionVoucher::class,
        ];

        /** @var PromotionAnswer|PromotionTest|PromotionLink $promotion */
        $promotion = new $promotionsClasses[$data['promKind']]($content);
        if ($promotion->getType() == PromotionLink::getType()) {
            $promotion->label = $data['linkLabel'];
            $promotion->url = $data['linkUrl'];
        }
        if ($promotion->getType() == PromotionAnswer::getType()) {
            $promotion->label = $data['answerLabel'];
        }
        if ($promotion->getType() == PromotionVoucher::getType()) {
            $promotion->label = $data['voucherLabel'];
        }
        if ($promotion->getType() == PromotionTest::getType()) {
            $testAnswersCorrectly = $data['testAnswersCorrectly'] ?? [];
            foreach ($data['testAnswers'] as $index => $option) {
                $promotion->addRawOption($option, in_array($index, $testAnswersCorrectly));
            }
        }

        if (isset($data['premiumName'])) {
            $premium = new PremiumPromotion();
            $premium
                ->setName($data['premiumName'])
                ->setRule($data['premiumRule'])
                ->setValidAt($data['premiumValidAt'])
                ->setRewardAmount($data['premiumRewardAmount'] ?? null)
                ->setWinMethod($data['premiumWinMethod'])
                ->setLotteryAt($data['premiumLotteryAt'] ?? null)
                ->setRewardOnlyCorrect($data['premiumRewardOnlyCorrect'] ?? false);
            $promotion->setPremium($premium);
        }

        return $promotion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = Content::find($id);
        if ($content === null) {
            return response()->json([
                '_cod' => 'radio-content/destroy/not-found',
            ], 404);
        }

        if ($content->radio_id !== session('radio_id')) {
            return response()->json([
                '_cod' => 'radio-content/destroy/unauthorized',
            ], 401);
        }

        try {
            $content->delete();
        } catch (\Throwable $t) {
            return response()->json([
                '_cod' => 'radio-content/destroy/*',
                'err' => [$t->getMessage()]
            ], 500);
        }
        return response()->json([
            '_cod' => 'ok',
        ]);
    }
}
