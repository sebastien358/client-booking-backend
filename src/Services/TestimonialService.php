<?php

namespace App\Services;

use App\Entity\Testimonial;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestimonialService
{
    public function testimonialDisplay($testimonials, $request, $serializer)
    {

        $elems = ['groups' => ['testimonials', 'picture'], 'circular_reference_handler' => function ($object) {
            return $object->getId();
        }];

        $urlImage = $request->getSchemeAndHttpHost() . '/images/';


        if (!is_array($testimonials)) {
            $data = $serializer->normalize($testimonials, 'json', $elems);

            if (!empty($data['picture']['filename'])) {
                $data['picture']['filename'] = $urlImage . $data['picture']['filename'];
            }

            return $data;
        }

        $dataList = $serializer->normalize($testimonials, 'json', $elems);

        foreach ($dataList as &$item) {
            if (!empty($item['picture']['filename'])) {
                $item['picture']['filename'] = $urlImage . $item['picture']['filename'];
            }
        }

        return $dataList;
    }
}