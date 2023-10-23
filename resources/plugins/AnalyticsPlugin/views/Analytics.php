<?php use Sapphire\Json\Json; ?>

<AnalyticsPlugin
    weekly_views="<?php echo $params["plugin"]->GetViews(ANALYTICS_WEEK); ?>"
    weekly_new_visitors="<?php echo $params["plugin"]->GetNewVisitors(ANALYTICS_WEEK); ?>"
    weekly_visitors="<?php echo $params["plugin"]->GetVisitors(ANALYTICS_WEEK); ?>"
    :month_views="<?php echo Json::String($params["plugin"]->GetMonthViewsArray()); ?>"
    :month_new_visitors="<?php echo Json::String($params["plugin"]->GetMonthNewVisitorsArray()); ?>"
    :month_visitors="<?php echo Json::String($params["plugin"]->GetMonthVisitorsArray()); ?>"
></AnalyticsPlugin>