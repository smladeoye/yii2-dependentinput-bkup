<?php
namespace smladeoye\dependentinput;

use yii\base\Widget;
use yii\web\View;
use yii\base\InvalidConfigException;
use smladeoye\dependentinput\DependentInputAsset;

class DependentInputWidget extends Widget
{
    const CHILD_TYPE_TEXT = "text";

    const CHILD_TYPE_SELECT = "select";

    public $options;

    public $displayLoader = true;

    private $required = ['child', 'parent', 'url'];

    public function init()
    {
        if (!is_array($this->options[0]))
            $this->options = [$this->options];

        $this->validateOptions($this->options);
        parent::init();
    }

    private function validateOptions($options)
    {
        foreach ($options as $option) {
            $keys = array_keys($option);

            foreach ($this->required as $required) {
                if (!in_array($required, $keys)) {
                    throw new InvalidConfigException("$required paramter must be set");
                }
            }
        }
    }

    public function run()
    {
        $this->registerAssets();
        parent::run();
    }

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();

        $options = json_encode($this->options);
        $displayLoader = $this->displayLoader ? 1 : 0;

        $js = <<<JS

        (function($,undefined){
            var options = $options ;
            var displayLoader = $displayLoader ;

        $.each(options, function (key, val) {

        var parent = val.parent;
        var child = '#' + val.child;
        var child_type = val['type'];
        var result_attr = val.resultAttr;
        var default_attr = val.elementAttr;
        var url = val.url;

        var otherOptions = {"result_attr":result_attr, "default_attr": default_attr,"child_type": child_type};

        if ($.isArray(val.parent) || $.isPlainObject(val.parent))
        {
            parent = $.each(parent, function (key,val) { parent[key] = "#" + val; });
        }
        else
        {
            parent = '#' + val.parent;
        }
        dependentInput(parent, child, url, otherOptions);
    });

    if (displayLoader)
    {
        $(document).ajaxStart(function (event, xhr, settings) {
        $.LoadingOverlay("show");
        });

        $(document).ajaxComplete(function (event, xhr, settings) {
        $.LoadingOverlay("hide");
        });
    }

    function dependentInput(parentId, childId, requestUrl, options) {
        var result_attr = options.result_attr || {};
        var default_attr = options.default_attr || {};
        var child_type = options.child_type || 'select';
        var parentElement;

        if (!$.isArray(parentId) && !$.isPlainObject(parentId))
        {
            parentId = [parentId];
        }

        parentElement = $.map(parentId,function(val,key){ return val; }).join(",");

        $(parentElement).change(function (e) {
            var currentValue = $(this).val();
            var url = requestUrl;
            var params = {params:{}};

            params.params = $.extend(params.params,parentId);

            if ($.trim(currentValue) != "" && currentValue != undefined)
            {
                var vals = params.params;
                $.each(vals,function(key,val){ vals[key] = $(val).val(); });
                sendRequest(url, childId, params, result_attr, child_type);
            }
            else {
                renderDefaultValue(childId, default_attr);
            }
        });
    }

    function sendRequest(url, childId, data, result_attr, child_type) {
        $.get(url, data, function (response) {
        try
        {
            response = JSON.parse(response);
        }
        catch (error)
        {}
        renderResult(response, childId, result_attr || {}, child_type);
        });
    }

    function renderResult(result, childId, result_attr, type) {
        if (type != "select") {
            $(childId).val(result);
            $.each(result_attr,function (index, value) {
                $(childId).attr(value, result);
            });
        }
        else {
            var emptyPlaceholder = $(childId).attr('empty');

            if (emptyPlaceholder != undefined || emptyPlaceholder != "")
                $(childId).html(getSelectOptions(result,emptyPlaceholder));
            else
                $(childId).html(getSelectOptions(result));
        }
    }

    function renderDefaultValue(childId, default_attr, type = "text") {
        if (type == "text") {
            $.each(default_attr, function (index, val) {
                $(childId).attr(index, val);
            });
            var value = $(childId).attr('value');
            $(childId).val(value);
        }
        else {

        }
    }

    function getSelectOptions(result,empty_string = "Select ...")
    {
        var opt = "<option value=''>"+empty_string+"</option>";
        $.each(result,function(value,display)
        {
            opt += "<option value='" + value + "'>"+ display +"</option>";
        });
        return opt;
    }
        }
        (jQuery)
        );
JS;
        DependentInputAsset::register($view);
        $view->registerJs($js, View::POS_READY);
    }
}