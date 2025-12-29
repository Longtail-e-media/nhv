<?php
/**
 *      FAQ Page
 */
$faq_details = '';

if (defined('FAQ_PAGE')) {

    $faqs = Faq::find_all();

    if (!empty($faqs)) {
        foreach ($faqs as $i => $faq) {
            $collapsed = ($i == 0) ? '' : 'collapsed';
            $show = ($i == 0) ? 'show' : '';
            $faq_details .= '
                <div class="collapse-item">
                    <div class="collapse-header" id="faqAccordion_03_g1-heading' . $faq->id . '">
                        <h5 class="collapse-title">
                            <a class="collapse-link ' . $collapsed . '" data-toggle="collapse" data-target="#faqAccordion_03_g1-collapse' . $faq->id . '" aria-expanded="false" aria-controls="faqAccordion_03_g1-collapse' . $faq->id . '">
                                ' . $faq->title . '
                            </a>
                        </h5>
                    </div>
                    <div id="faqAccordion_03_g1-collapse' . $faq->id . '" class="collapse ' . $show . '" aria-labelledby="faqAccordion_03_g1-heading' . $faq->id . '" data-parent="#faqAccordion_03_g1">
                        <div class="collapse-body">
                            <div class="collapse-inner">
                                ' . $faq->content . '
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        $faq_details .= '<h3 class="text-center p-4">No FAQ Found</h3>';
    }
}

$jVars['module:faq:details'] = $faq_details;


/**
 *      Homepage
 */
$faq_details = '';

if (defined('HOME_PAGE')) {

    $faqs = Faq::find_few(3);

    if (!empty($faqs)) {
        $faq_details .= '';

        foreach ($faqs as $i => $faq) {
            $collapsed = ($i == 0) ? 'mad-panels-active' : '';
            $show = ($i == 0) ? 'show' : '';
            $faq_details .= '
            <dt class="mad-panels-title ' . $collapsed . '">
                <button id="' . $faq->id . '-button" type="button" aria-expanded="false" aria-controls="' . $faq->id . '" aria-disabled="false">
                ' . $faq->title . '
                </button>
            </dt>
            <dd id="' . $faq->id . '" class="mad-panels-definition">
                <p> ' . $faq->content . '</p>
            </dd>

                
                ';
        }

        $faq_details .= '';
    } else {
        $faq_details .= '<h3 class="text-center p-4">No FAQ Found</h3>';
    }
}

$jVars['module:faq:details-homepage'] = $faq_details;

$jVars['module:faqlink'] = BASE_URL . 'faq';