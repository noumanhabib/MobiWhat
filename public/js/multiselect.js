!(function (root, factory) {
    "function" == typeof define &&
    define.amd &&
    "function" == typeof require &&
    "function" == typeof require.specified &&
    require.specified("knockout")
        ? define(["jquery", "knockout"], factory)
        : factory(root.jQuery, root.ko);
})(this, function ($, ko) {
    "use strict";
    function forEach(array, callback) {
        for (var index = 0; index < array.length; ++index)
            callback(array[index], index);
    }
    function Multiselect(select, options) {
        (this.$select = $(select)),
            (this.options = this.mergeOptions(
                $.extend({}, options, this.$select.data())
            )),
            this.$select.attr("data-placeholder") &&
                (this.options.nonSelectedText =
                    this.$select.data("placeholder")),
            (this.originalOptions = this.$select.clone()[0].options),
            (this.query = ""),
            (this.searchTimeout = null),
            (this.lastToggledInput = null),
            (this.options.multiple =
                "multiple" === this.$select.attr("multiple")),
            (this.options.onChange = $.proxy(this.options.onChange, this)),
            (this.options.onSelectAll = $.proxy(
                this.options.onSelectAll,
                this
            )),
            (this.options.onDeselectAll = $.proxy(
                this.options.onDeselectAll,
                this
            )),
            (this.options.onDropdownShow = $.proxy(
                this.options.onDropdownShow,
                this
            )),
            (this.options.onDropdownHide = $.proxy(
                this.options.onDropdownHide,
                this
            )),
            (this.options.onDropdownShown = $.proxy(
                this.options.onDropdownShown,
                this
            )),
            (this.options.onDropdownHidden = $.proxy(
                this.options.onDropdownHidden,
                this
            )),
            (this.options.onInitialized = $.proxy(
                this.options.onInitialized,
                this
            )),
            (this.options.onFiltering = $.proxy(
                this.options.onFiltering,
                this
            )),
            this.buildContainer(),
            this.buildButton(),
            this.buildDropdown(),
            this.buildReset(),
            this.buildSelectAll(),
            this.buildDropdownOptions(),
            this.buildFilter(),
            this.updateButtonText(),
            this.updateSelectAll(!0),
            this.options.enableClickableOptGroups &&
                this.options.multiple &&
                this.updateOptGroups(),
            (this.options.wasDisabled = this.$select.prop("disabled")),
            this.options.disableIfEmpty &&
                $("option", this.$select).length <= 0 &&
                this.disable(),
            this.$select
                .wrap('<span class="multiselect-native-select" />')
                .after(this.$container),
            this.options.onInitialized(this.$select, this.$container);
    }
    void 0 !== ko &&
        ko.bindingHandlers &&
        !ko.bindingHandlers.multiselect &&
        (ko.bindingHandlers.multiselect = {
            after: ["options", "value", "selectedOptions", "enable", "disable"],
            init: function (
                element,
                valueAccessor,
                allBindings,
                viewModel,
                bindingContext
            ) {
                var $element = $(element),
                    config = ko.toJS(valueAccessor());
                if (
                    ($element.multiselect(config), allBindings.has("options"))
                ) {
                    var options = allBindings.get("options");
                    ko.isObservable(options) &&
                        ko.computed({
                            read: function () {
                                options(),
                                    setTimeout(function () {
                                        var ms = $element.data("multiselect");
                                        ms && ms.updateOriginalOptions(),
                                            $element.multiselect("rebuild");
                                    }, 1);
                            },
                            disposeWhenNodeIsRemoved: element,
                        });
                }
                if (allBindings.has("value")) {
                    var value = allBindings.get("value");
                    ko.isObservable(value) &&
                        ko
                            .computed({
                                read: function () {
                                    value(),
                                        setTimeout(function () {
                                            $element.multiselect("refresh");
                                        }, 1);
                                },
                                disposeWhenNodeIsRemoved: element,
                            })
                            .extend({
                                rateLimit: 100,
                                notifyWhenChangesStop: !0,
                            });
                }
                if (allBindings.has("selectedOptions")) {
                    var selectedOptions = allBindings.get("selectedOptions");
                    ko.isObservable(selectedOptions) &&
                        ko
                            .computed({
                                read: function () {
                                    selectedOptions(),
                                        setTimeout(function () {
                                            $element.multiselect("refresh");
                                        }, 1);
                                },
                                disposeWhenNodeIsRemoved: element,
                            })
                            .extend({
                                rateLimit: 100,
                                notifyWhenChangesStop: !0,
                            });
                }
                var setEnabled = function (enable) {
                    setTimeout(function () {
                        enable
                            ? $element.multiselect("enable")
                            : $element.multiselect("disable");
                    });
                };
                if (allBindings.has("enable")) {
                    var enable = allBindings.get("enable");
                    ko.isObservable(enable)
                        ? ko
                              .computed({
                                  read: function () {
                                      setEnabled(enable());
                                  },
                                  disposeWhenNodeIsRemoved: element,
                              })
                              .extend({
                                  rateLimit: 100,
                                  notifyWhenChangesStop: !0,
                              })
                        : setEnabled(enable);
                }
                if (allBindings.has("disable")) {
                    var disable = allBindings.get("disable");
                    ko.isObservable(disable)
                        ? ko
                              .computed({
                                  read: function () {
                                      setEnabled(!disable());
                                  },
                                  disposeWhenNodeIsRemoved: element,
                              })
                              .extend({
                                  rateLimit: 100,
                                  notifyWhenChangesStop: !0,
                              })
                        : setEnabled(!disable);
                }
                ko.utils.domNodeDisposal.addDisposeCallback(
                    element,
                    function () {
                        $element.multiselect("destroy");
                    }
                );
            },
            update: function (
                element,
                valueAccessor,
                allBindings,
                viewModel,
                bindingContext
            ) {
                var $element = $(element),
                    config = ko.toJS(valueAccessor());
                $element.multiselect("setOptions", config),
                    $element.multiselect("rebuild");
            },
        }),
        (Multiselect.prototype = {
            defaults: {
                buttonText: function (selectedOptions, select) {
                    if (this.disabledText.length > 0 && select.prop("disabled"))
                        return this.disabledText;
                    if (0 === selectedOptions.length)
                        return this.nonSelectedText;
                    if (
                        this.allSelectedText &&
                        selectedOptions.length ===
                            $("option", $(select)).length &&
                        1 !== $("option", $(select)).length &&
                        this.multiple
                    )
                        return this.selectAllNumber
                            ? this.allSelectedText +
                                  " (" +
                                  selectedOptions.length +
                                  ")"
                            : this.allSelectedText;
                    if (
                        0 != this.numberDisplayed &&
                        selectedOptions.length > this.numberDisplayed
                    )
                        return (
                            selectedOptions.length + " " + this.nSelectedText
                        );
                    var selected = "",
                        delimiter = this.delimiterText;
                    return (
                        selectedOptions.each(function () {
                            var label =
                                void 0 !== $(this).attr("label")
                                    ? $(this).attr("label")
                                    : $(this).text();
                            selected += label + delimiter;
                        }),
                        selected.substr(
                            0,
                            selected.length - this.delimiterText.length
                        )
                    );
                },
                buttonTitle: function (options, select) {
                    if (0 === options.length) return this.nonSelectedText;
                    var selected = "",
                        delimiter = this.delimiterText;
                    return (
                        options.each(function () {
                            var label =
                                void 0 !== $(this).attr("label")
                                    ? $(this).attr("label")
                                    : $(this).text();
                            selected += label + delimiter;
                        }),
                        selected.substr(
                            0,
                            selected.length - this.delimiterText.length
                        )
                    );
                },
                checkboxName: function (option) {
                    return !1;
                },
                optionLabel: function (element) {
                    return $(element).attr("label") || $(element).text();
                },
                optionClass: function (element) {
                    return $(element).attr("class") || "";
                },
                onChange: function (option, checked) {},
                onDropdownShow: function (event) {},
                onDropdownHide: function (event) {},
                onDropdownShown: function (event) {},
                onDropdownHidden: function (event) {},
                onSelectAll: function () {},
                onDeselectAll: function () {},
                onInitialized: function ($select, $container) {},
                onFiltering: function ($filter) {},
                enableHTML: !1,
                buttonClass: "custom-select",
                inheritClass: !1,
                buttonWidth: "auto",
                buttonContainer: '<div class="btn-group" />',
                dropRight: !1,
                dropUp: !1,
                selectedClass: "active",
                maxHeight: !1,
                includeSelectAllOption: !1,
                includeSelectAllIfMoreThan: 0,
                selectAllText: " Select all",
                selectAllValue: "multiselect-all",
                selectAllName: !1,
                selectAllNumber: !0,
                selectAllJustVisible: !0,
                enableFiltering: !1,
                enableCaseInsensitiveFiltering: !1,
                enableFullValueFiltering: !1,
                enableClickableOptGroups: !1,
                enableCollapsibleOptGroups: !1,
                collapseOptGroupsByDefault: !1,
                filterPlaceholder: "Search",
                filterBehavior: "text",
                includeFilterClearBtn: !0,
                preventInputChangeEvent: !1,
                nonSelectedText: "None selected",
                nSelectedText: "selected",
                allSelectedText: "All selected",
                numberDisplayed: 3,
                disableIfEmpty: !1,
                disabledText: "",
                delimiterText: ", ",
                includeResetOption: !1,
                includeResetDivider: !1,
                resetText: "Reset",
                indentGroupOptions: !0,
                templates: {
                    button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                    popupContainer:
                        '<div class="multiselect-container dropdown-menu"></div>',
                    filter: '<div class="multiselect-filter d-flex align-items-center"><i class="fas fa-sm fa-search text-muted"></i><input type="search" class="multiselect-search form-control" /></div>',
                    option: '<button type="button" class="multiselect-option dropdown-item"></button>',
                    divider: '<div class="dropdown-divider"></div>',
                    optionGroup:
                        '<button type="button" class="multiselect-group dropdown-item"></button>',
                    resetButton:
                        '<div class="multiselect-reset text-center p-2"><button type="button" class="btn btn-sm btn-block btn-outline-secondary"></button></div>',
                },
            },
            constructor: Multiselect,
            buildContainer: function () {
                (this.$container = $(this.options.buttonContainer)),
                    this.$container.on(
                        "show.bs.dropdown",
                        this.options.onDropdownShow
                    ),
                    this.$container.on(
                        "hide.bs.dropdown",
                        this.options.onDropdownHide
                    ),
                    this.$container.on(
                        "shown.bs.dropdown",
                        this.options.onDropdownShown
                    ),
                    this.$container.on(
                        "hidden.bs.dropdown",
                        this.options.onDropdownHidden
                    );
            },
            buildButton: function () {
                (this.$button = $(this.options.templates.button).addClass(
                    this.options.buttonClass
                )),
                    this.$select.attr("class") &&
                        this.options.inheritClass &&
                        this.$button.addClass(this.$select.attr("class")),
                    this.$select.prop("disabled")
                        ? this.disable()
                        : this.enable(),
                    this.options.buttonWidth &&
                        "auto" !== this.options.buttonWidth &&
                        (this.$button.css({
                            width: "100%",
                            overflow: "hidden",
                            "text-overflow": "ellipsis",
                        }),
                        this.$container.css({
                            width: this.options.buttonWidth,
                        }));
                var tabindex = this.$select.attr("tabindex");
                tabindex && this.$button.attr("tabindex", tabindex),
                    this.$container.prepend(this.$button);
            },
            buildDropdown: function () {
                (this.$popupContainer = $(
                    this.options.templates.popupContainer
                )),
                    this.options.dropRight
                        ? this.$container.addClass("dropright")
                        : this.options.dropUp &&
                          this.$container.addClass("dropup"),
                    this.options.maxHeight &&
                        this.$popupContainer.css({
                            "max-height": this.options.maxHeight + "px",
                            "overflow-y": "auto",
                            "overflow-x": "hidden",
                        }),
                    this.$popupContainer.on("touchstart click", function (e) {
                        e.stopPropagation();
                    }),
                    this.$container.append(this.$popupContainer);
            },
            buildDropdownOptions: function () {
                this.$select.children().each(
                    $.proxy(function (index, element) {
                        var $element = $(element),
                            tag = $element.prop("tagName").toLowerCase();
                        $element.prop("value") !==
                            this.options.selectAllValue &&
                            ("optgroup" === tag
                                ? this.createOptgroup(element)
                                : "option" === tag &&
                                  ("divider" === $element.data("role")
                                      ? this.createDivider()
                                      : this.createOptionValue(element, !1)));
                    }, this)
                ),
                    $(this.$popupContainer).off(
                        "change",
                        '> *:not(.multiselect-group) input[type="checkbox"], > *:not(.multiselect-group) input[type="radio"]'
                    ),
                    $(this.$popupContainer).on(
                        "change",
                        '> *:not(.multiselect-group) input[type="checkbox"], > *:not(.multiselect-group) input[type="radio"]',
                        $.proxy(function (event) {
                            var $target = $(event.target),
                                checked = $target.prop("checked") || !1,
                                isSelectAllOption =
                                    $target.val() ===
                                    this.options.selectAllValue;
                            this.options.selectedClass &&
                                (checked
                                    ? $target
                                          .closest(".multiselect-option")
                                          .addClass(this.options.selectedClass)
                                    : $target
                                          .closest(".multiselect-option")
                                          .removeClass(
                                              this.options.selectedClass
                                          ));
                            var value = $target.val(),
                                $option = this.getOptionByValue(value),
                                $optionsNotThis = $("option", this.$select).not(
                                    $option
                                ),
                                $checkboxesNotThis = $(
                                    "input",
                                    this.$container
                                ).not($target);
                            if (
                                (isSelectAllOption
                                    ? checked
                                        ? this.selectAll(
                                              this.options.selectAllJustVisible,
                                              !0
                                          )
                                        : this.deselectAll(
                                              this.options.selectAllJustVisible,
                                              !0
                                          )
                                    : (checked
                                          ? ($option.prop("selected", !0),
                                            this.options.multiple
                                                ? $option.prop("selected", !0)
                                                : (this.options.selectedClass &&
                                                      $($checkboxesNotThis)
                                                          .closest(
                                                              ".dropdown-item"
                                                          )
                                                          .removeClass(
                                                              this.options
                                                                  .selectedClass
                                                          ),
                                                  $($checkboxesNotThis).prop(
                                                      "checked",
                                                      !1
                                                  ),
                                                  $optionsNotThis.prop(
                                                      "selected",
                                                      !1
                                                  ),
                                                  this.$button.click()),
                                            "active" ===
                                                this.options.selectedClass &&
                                                $optionsNotThis
                                                    .closest(".dropdown-item")
                                                    .css("outline", ""))
                                          : $option.prop("selected", !1),
                                      this.options.onChange($option, checked),
                                      this.updateSelectAll(),
                                      this.options.enableClickableOptGroups &&
                                          this.options.multiple &&
                                          this.updateOptGroups()),
                                this.$select.change(),
                                this.updateButtonText(),
                                this.options.preventInputChangeEvent)
                            )
                                return !1;
                        }, this)
                    ),
                    $(".multiselect-option", this.$popupContainer).off(
                        "mousedown"
                    ),
                    $(".multiselect-option", this.$popupContainer).on(
                        "mousedown",
                        function (e) {
                            if (e.shiftKey) return !1;
                        }
                    ),
                    $(this.$popupContainer).off(
                        "touchstart click",
                        ".multiselect-option, .multiselect-all, .multiselect-group"
                    ),
                    $(this.$popupContainer).on(
                        "touchstart click",
                        ".multiselect-option, .multiselect-all, .multiselect-group",
                        $.proxy(function (event) {
                            event.stopPropagation();
                            var $target = $(event.target),
                                $input;
                            if (event.shiftKey && this.options.multiple) {
                                $target.is("input") ||
                                    (event.preventDefault(),
                                    ($target = $target
                                        .closest(".multiselect-option")
                                        .find("input")).prop(
                                        "checked",
                                        !$target.prop("checked")
                                    ));
                                var checked = $target.prop("checked") || !1;
                                if (
                                    null !== this.lastToggledInput &&
                                    this.lastToggledInput !== $target
                                ) {
                                    var from = this.$popupContainer
                                            .find(".multiselect-option:visible")
                                            .index(
                                                $target.closest(
                                                    ".multiselect-option"
                                                )
                                            ),
                                        to = this.$popupContainer
                                            .find(".multiselect-option:visible")
                                            .index(
                                                this.lastToggledInput.closest(
                                                    ".multiselect-option"
                                                )
                                            );
                                    if (from > to) {
                                        var tmp = to;
                                        (to = from), (from = tmp);
                                    }
                                    ++to;
                                    var range = this.$popupContainer
                                        .find(
                                            ".multiselect-option:not(.multiselect-filter-hidden)"
                                        )
                                        .slice(from, to)
                                        .find("input");
                                    range.prop("checked", checked),
                                        this.options.selectedClass &&
                                            range
                                                .closest(".multiselect-option")
                                                .toggleClass(
                                                    this.options.selectedClass,
                                                    checked
                                                );
                                    for (
                                        var i = 0, j = range.length;
                                        i < j;
                                        i++
                                    ) {
                                        var $checkbox = $(range[i]),
                                            $option;
                                        this.getOptionByValue(
                                            $checkbox.val()
                                        ).prop("selected", checked);
                                    }
                                }
                                $target.trigger("change");
                            } else if (!$target.is("input")) {
                                var $checkbox;
                                if (
                                    ($checkbox = $target
                                        .closest(
                                            ".multiselect-option, .multiselect-all"
                                        )
                                        .find(".form-check-input")).length > 0
                                )
                                    $checkbox.prop(
                                        "checked",
                                        !$checkbox.prop("checked")
                                    ),
                                        $checkbox.change();
                                else if (
                                    this.options.enableClickableOptGroups &&
                                    this.options.multiple &&
                                    !$target.hasClass("caret-container")
                                ) {
                                    var groupItem = $target;
                                    groupItem.hasClass("multiselect-group") ||
                                        (groupItem =
                                            $target.closest(
                                                ".multiselect-group"
                                            )),
                                        ($checkbox =
                                            groupItem.find(".form-check-input"))
                                            .length > 0 &&
                                            ($checkbox.prop(
                                                "checked",
                                                !$checkbox.prop("checked")
                                            ),
                                            $checkbox.change());
                                }
                                event.preventDefault();
                            }
                            $target
                                .closest(".multiselect-option")
                                .find(
                                    "input[type='checkbox'], input[type='radio']"
                                ).length > 0
                                ? (this.lastToggledInput = $target)
                                : (this.lastToggledInput = null),
                                $target.blur();
                        }, this)
                    ),
                    this.$container.off("keydown.multiselect").on(
                        "keydown.multiselect",
                        $.proxy(function (event) {
                            if (
                                !$(
                                    "input.multiselect-search",
                                    this.$container
                                ).is(":focus")
                            )
                                if (
                                    9 === event.keyCode &&
                                    this.$container.hasClass("show")
                                )
                                    this.$button.click();
                                else {
                                    var $items = $(this.$container)
                                        .find(
                                            ".multiselect-option:not(.disabled), .multiselect-group:not(.disabled), .multiselect-all"
                                        )
                                        .filter(":visible");
                                    if (!$items.length) return;
                                    var index = $items.index(
                                            $items.filter(":focus")
                                        ),
                                        $current = $items.eq(index);
                                    if (32 === event.keyCode) {
                                        var $checkbox = $current.find("input");
                                        $checkbox.prop(
                                            "checked",
                                            !$checkbox.prop("checked")
                                        ),
                                            $checkbox.change(),
                                            event.preventDefault();
                                    }
                                    13 === event.keyCode &&
                                        setTimeout(function () {
                                            $current.focus();
                                        }, 0);
                                }
                        }, this)
                    ),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        ($(
                            ".multiselect-group input",
                            this.$popupContainer
                        ).off("change"),
                        $(".multiselect-group input", this.$popupContainer).on(
                            "change",
                            $.proxy(function (event) {
                                event.stopPropagation();
                                var $target,
                                    checked =
                                        $(event.target).prop("checked") || !1,
                                    $item = $(event.target).closest(
                                        ".dropdown-item"
                                    ),
                                    $group,
                                    $inputs = $item
                                        .nextUntil(".multiselect-group")
                                        .not(".multiselect-filter-hidden")
                                        .not(".disabled")
                                        .find("input"),
                                    $options = [];
                                this.options.selectedClass &&
                                    (checked
                                        ? $item.addClass(
                                              this.options.selectedClass
                                          )
                                        : $item.removeClass(
                                              this.options.selectedClass
                                          )),
                                    $.each(
                                        $inputs,
                                        $.proxy(function (index, input) {
                                            var $input = $(input),
                                                value = $input.val(),
                                                $option =
                                                    this.getOptionByValue(
                                                        value
                                                    );
                                            checked
                                                ? ($input.prop("checked", !0),
                                                  $input
                                                      .closest(".dropdown-item")
                                                      .addClass(
                                                          this.options
                                                              .selectedClass
                                                      ),
                                                  $option.prop("selected", !0))
                                                : ($input.prop("checked", !1),
                                                  $input
                                                      .closest(".dropdown-item")
                                                      .removeClass(
                                                          this.options
                                                              .selectedClass
                                                      ),
                                                  $option.prop("selected", !1)),
                                                $options.push(
                                                    this.getOptionByValue(value)
                                                );
                                        }, this)
                                    ),
                                    this.options.onChange($options, checked),
                                    this.$select.change(),
                                    this.updateButtonText(),
                                    this.updateSelectAll();
                            }, this)
                        )),
                    this.options.enableCollapsibleOptGroups &&
                        this.options.multiple &&
                        ($(
                            ".multiselect-group .caret-container",
                            this.$popupContainer
                        ).off("click"),
                        $(
                            ".multiselect-group .caret-container",
                            this.$popupContainer
                        ).on(
                            "click",
                            $.proxy(function (event) {
                                var $group,
                                    $inputs = $(event.target)
                                        .closest(".multiselect-group")
                                        .nextUntil(".multiselect-group")
                                        .not(".multiselect-filter-hidden"),
                                    visible = !0;
                                $inputs.each(function () {
                                    visible =
                                        visible &&
                                        !$(this).hasClass(
                                            "multiselect-collapsible-hidden"
                                        );
                                }),
                                    visible
                                        ? $inputs
                                              .hide()
                                              .addClass(
                                                  "multiselect-collapsible-hidden"
                                              )
                                        : $inputs
                                              .show()
                                              .removeClass(
                                                  "multiselect-collapsible-hidden"
                                              );
                            }, this)
                        ));
            },
            createCheckbox: function (
                $item,
                label,
                name,
                value,
                title,
                inputType
            ) {
                var $wrapper = $("<span />");
                if (
                    ($wrapper.addClass("form-check"),
                    this.options.enableHTML && $(label).length > 0)
                )
                    $wrapper.append($(label));
                else {
                    var $checkboxLabel = $(
                        '<label class="form-check-label" />'
                    );
                    $checkboxLabel.text(label), $wrapper.append($checkboxLabel);
                }
                var $checkbox = $('<input class="form-check-input"/>').attr(
                    "type",
                    inputType
                );
                return (
                    $checkbox.val(value),
                    $wrapper.prepend($checkbox),
                    name && $checkbox.attr("name", name),
                    $item.prepend($wrapper),
                    $item.attr("title", title || label),
                    $checkbox
                );
            },
            createOptionValue: function (element, isGroupOption) {
                var $element = $(element);
                $element.is(":selected") && $element.prop("selected", !0);
                var label = this.options.optionLabel(element),
                    classes = this.options.optionClass(element),
                    value = $element.val(),
                    inputType = this.options.multiple ? "checkbox" : "radio",
                    title = $element.attr("title"),
                    $option = $(this.options.templates.option);
                $option.addClass(classes),
                    isGroupOption &&
                        this.options.indentGroupOptions &&
                        $option.addClass("multiselect-group-option-indented"),
                    this.options.collapseOptGroupsByDefault &&
                        "optgroup" ===
                            $(element).parent().prop("tagName").toLowerCase() &&
                        ($option.addClass("multiselect-collapsible-hidden"),
                        $option.hide());
                var name = this.options.checkboxName($element),
                    $checkbox = this.createCheckbox(
                        $option,
                        label,
                        name,
                        value,
                        title,
                        inputType
                    ),
                    selected = $element.prop("selected") || !1;
                value === this.options.selectAllValue &&
                    ($option.addClass("multiselect-all"),
                    $option.removeClass("multiselect-option"),
                    $checkbox.parent().parent().addClass("multiselect-all")),
                    this.$popupContainer.append($option),
                    $element.is(":disabled") &&
                        $checkbox
                            .attr("disabled", "disabled")
                            .prop("disabled", !0)
                            .closest(".dropdown-item")
                            .addClass("disabled"),
                    $checkbox.prop("checked", selected),
                    selected &&
                        this.options.selectedClass &&
                        $checkbox
                            .closest(".dropdown-item")
                            .addClass(this.options.selectedClass);
            },
            createDivider: function (element) {
                var $divider = $(this.options.templates.divider);
                this.$popupContainer.append($divider);
            },
            createOptgroup: function (group) {
                var $group = $(group),
                    label = $group.attr("label"),
                    value = $group.attr("value"),
                    title = $group.attr("title"),
                    $groupOption = $(
                        "<span class='multiselect-group dropdown-item-text'></span>"
                    );
                if (
                    this.options.enableClickableOptGroups &&
                    this.options.multiple
                ) {
                    $groupOption = $(this.options.templates.optionGroup);
                    var $checkbox = this.createCheckbox(
                        $groupOption,
                        label,
                        null,
                        value,
                        title,
                        "checkbox"
                    );
                } else
                    this.options.enableHTML
                        ? $groupOption.html(" " + label)
                        : $groupOption.text(" " + label);
                var classes = this.options.optionClass(group);
                $groupOption.addClass(classes),
                    this.options.enableCollapsibleOptGroups &&
                        this.options.multiple &&
                        ($groupOption
                            .find(".form-check")
                            .addClass("d-inline-block"),
                        $groupOption.append(
                            '<span class="caret-container dropdown-toggle pl-1"></span>'
                        )),
                    $group.is(":disabled") && $groupOption.addClass("disabled"),
                    this.$popupContainer.append($groupOption),
                    $("option", group).each(
                        $.proxy(function ($, group) {
                            this.createOptionValue(group, !0);
                        }, this)
                    );
            },
            buildReset: function () {
                if (this.options.includeResetOption) {
                    if (this.options.includeResetDivider) {
                        var divider = $(this.options.templates.divider);
                        divider.addClass("mt-0"),
                            this.$popupContainer.prepend(divider);
                    }
                    var $resetButton = $(this.options.templates.resetButton);
                    this.options.enableHTML
                        ? $("button", $resetButton).html(this.options.resetText)
                        : $("button", $resetButton).text(
                              this.options.resetText
                          ),
                        $("button", $resetButton).click(
                            $.proxy(function () {
                                this.clearSelection();
                            }, this)
                        ),
                        this.$popupContainer.prepend($resetButton);
                }
            },
            buildSelectAll: function () {
                var alreadyHasSelectAll;
                if (
                    ("number" == typeof this.options.selectAllValue &&
                        (this.options.selectAllValue =
                            this.options.selectAllValue.toString()),
                    !this.hasSelectAll() &&
                        this.options.includeSelectAllOption &&
                        this.options.multiple &&
                        $("option", this.$select).length >
                            this.options.includeSelectAllIfMoreThan)
                ) {
                    this.options.includeSelectAllDivider &&
                        this.$popupContainer.prepend(
                            $(this.options.templates.divider)
                        );
                    var $option = $(
                            this.options.templates.li ||
                                this.options.templates.option
                        ),
                        $checkbox = this.createCheckbox(
                            $option,
                            this.options.selectAllText,
                            this.options.selectAllName,
                            this.options.selectAllValue,
                            this.options.selectAllText,
                            "checkbox"
                        );
                    $option.addClass("multiselect-all"),
                        $option.removeClass("multiselect-option"),
                        $option
                            .find(".form-check-label")
                            .addClass("font-weight-bold"),
                        this.$popupContainer.prepend($option),
                        $checkbox.prop("checked", !1);
                }
            },
            buildFilter: function () {
                if (
                    this.options.enableFiltering ||
                    this.options.enableCaseInsensitiveFiltering
                ) {
                    var enableFilterLength = Math.max(
                        this.options.enableFiltering,
                        this.options.enableCaseInsensitiveFiltering
                    );
                    this.$select.find("option").length >= enableFilterLength &&
                        ((this.$filter = $(this.options.templates.filter)),
                        $("input", this.$filter).attr(
                            "placeholder",
                            this.options.filterPlaceholder
                        ),
                        this.options.includeFilterClearBtn
                            ? (this.isFirefox() &&
                                  0 ===
                                      this.$filter.find(
                                          ".multiselect-clear-filter"
                                      ).length &&
                                  this.$filter.append(
                                      "<i class='fas fa-times text-muted multiselect-clear-filter multiselect-moz-clear-filter'></i>"
                                  ),
                              this.$filter.find(".multiselect-clear-filter").on(
                                  "click",
                                  $.proxy(function (event) {
                                      clearTimeout(this.searchTimeout),
                                          (this.query = ""),
                                          this.$filter
                                              .find(".multiselect-search")
                                              .val(""),
                                          $(
                                              ".dropdown-item",
                                              this.$popupContainer
                                          )
                                              .show()
                                              .removeClass(
                                                  "multiselect-filter-hidden"
                                              ),
                                          this.updateSelectAll(),
                                          this.options
                                              .enableClickableOptGroups &&
                                              this.options.multiple &&
                                              this.updateOptGroups();
                                  }, this)
                              ))
                            : (this.$filter
                                  .find(".multiselect-search")
                                  .attr("type", "text"),
                              this.$filter
                                  .find(".multiselect-clear-filter")
                                  .remove()),
                        this.$popupContainer.prepend(this.$filter),
                        this.$filter
                            .val(this.query)
                            .on("click", function (event) {
                                event.stopPropagation();
                            })
                            .on(
                                "input keydown",
                                $.proxy(function (event) {
                                    13 === event.which &&
                                        event.preventDefault(),
                                        this.isFirefox() &&
                                            this.options
                                                .includeFilterClearBtn &&
                                            (event.target.value
                                                ? this.$filter
                                                      .find(
                                                          ".multiselect-moz-clear-filter"
                                                      )
                                                      .show()
                                                : this.$filter
                                                      .find(
                                                          ".multiselect-moz-clear-filter"
                                                      )
                                                      .hide()),
                                        clearTimeout(this.searchTimeout),
                                        (this.searchTimeout =
                                            this.asyncFunction(
                                                $.proxy(function () {
                                                    var currentGroup,
                                                        currentGroupVisible;
                                                    this.query !==
                                                        event.target.value &&
                                                        ((this.query =
                                                            event.target.value),
                                                        $.each(
                                                            $(
                                                                ".multiselect-option, .multiselect-group",
                                                                this
                                                                    .$popupContainer
                                                            ),
                                                            $.proxy(function (
                                                                index,
                                                                element
                                                            ) {
                                                                var value =
                                                                        $(
                                                                            "input",
                                                                            element
                                                                        )
                                                                            .length >
                                                                        0
                                                                            ? $(
                                                                                  "input",
                                                                                  element
                                                                              ).val()
                                                                            : "",
                                                                    text = $(
                                                                        ".form-check-label",
                                                                        element
                                                                    ).text(),
                                                                    filterCandidate =
                                                                        "";
                                                                if (
                                                                    ("text" ===
                                                                    this.options
                                                                        .filterBehavior
                                                                        ? (filterCandidate =
                                                                              text)
                                                                        : "value" ===
                                                                          this
                                                                              .options
                                                                              .filterBehavior
                                                                        ? (filterCandidate =
                                                                              value)
                                                                        : "both" ===
                                                                              this
                                                                                  .options
                                                                                  .filterBehavior &&
                                                                          (filterCandidate =
                                                                              text +
                                                                              "\n" +
                                                                              value),
                                                                    value !==
                                                                        this
                                                                            .options
                                                                            .selectAllValue &&
                                                                        text)
                                                                ) {
                                                                    var showElement =
                                                                        !1;
                                                                    if (
                                                                        (this
                                                                            .options
                                                                            .enableCaseInsensitiveFiltering &&
                                                                            ((filterCandidate =
                                                                                filterCandidate.toLowerCase()),
                                                                            (this.query =
                                                                                this.query.toLowerCase())),
                                                                        this
                                                                            .options
                                                                            .enableFullValueFiltering &&
                                                                            "both" !==
                                                                                this
                                                                                    .options
                                                                                    .filterBehavior)
                                                                    ) {
                                                                        var valueToMatch =
                                                                            filterCandidate
                                                                                .trim()
                                                                                .substring(
                                                                                    0,
                                                                                    this
                                                                                        .query
                                                                                        .length
                                                                                );
                                                                        this.query.indexOf(
                                                                            valueToMatch
                                                                        ) >
                                                                            -1 &&
                                                                            (showElement =
                                                                                !0);
                                                                    } else
                                                                        filterCandidate.indexOf(
                                                                            this
                                                                                .query
                                                                        ) >
                                                                            -1 &&
                                                                            (showElement =
                                                                                !0);
                                                                    showElement ||
                                                                        ($(
                                                                            element
                                                                        ).css(
                                                                            "display",
                                                                            "none"
                                                                        ),
                                                                        $(
                                                                            element
                                                                        ).addClass(
                                                                            "multiselect-filter-hidden"
                                                                        )),
                                                                        showElement &&
                                                                            ($(
                                                                                element
                                                                            ).css(
                                                                                "display",
                                                                                "block"
                                                                            ),
                                                                            $(
                                                                                element
                                                                            ).removeClass(
                                                                                "multiselect-filter-hidden"
                                                                            )),
                                                                        $(
                                                                            element
                                                                        ).hasClass(
                                                                            "multiselect-group"
                                                                        )
                                                                            ? ((currentGroup =
                                                                                  element),
                                                                              (currentGroupVisible =
                                                                                  showElement))
                                                                            : (showElement &&
                                                                                  $(
                                                                                      currentGroup
                                                                                  )
                                                                                      .show()
                                                                                      .removeClass(
                                                                                          "multiselect-filter-hidden"
                                                                                      ),
                                                                              !showElement &&
                                                                                  currentGroupVisible &&
                                                                                  $(
                                                                                      element
                                                                                  )
                                                                                      .show()
                                                                                      .removeClass(
                                                                                          "multiselect-filter-hidden"
                                                                                      ));
                                                                }
                                                            },
                                                            this)
                                                        ));
                                                    this.updateSelectAll(),
                                                        this.options
                                                            .enableClickableOptGroups &&
                                                            this.options
                                                                .multiple &&
                                                            this.updateOptGroups(),
                                                        this.options.onFiltering(
                                                            event.target
                                                        );
                                                }, this),
                                                300,
                                                this
                                            ));
                                }, this)
                            ));
                }
            },
            destroy: function () {
                this.$container.remove(),
                    this.$select.show(),
                    this.$select.prop("disabled", this.options.wasDisabled),
                    this.$select.data("multiselect", null);
            },
            refresh: function () {
                var inputs = {};
                $(".multiselect-option input", this.$popupContainer).each(
                    function () {
                        inputs[$(this).val()] = $(this);
                    }
                ),
                    $("option", this.$select).each(
                        $.proxy(function (index, element) {
                            var $elem = $(element),
                                $input = inputs[$(element).val()];
                            $elem.is(":selected")
                                ? ($input.prop("checked", !0),
                                  this.options.selectedClass &&
                                      $input
                                          .closest(".multiselect-option")
                                          .addClass(this.options.selectedClass))
                                : ($input.prop("checked", !1),
                                  this.options.selectedClass &&
                                      $input
                                          .closest(".multiselect-option")
                                          .removeClass(
                                              this.options.selectedClass
                                          )),
                                $elem.is(":disabled")
                                    ? $input
                                          .attr("disabled", "disabled")
                                          .prop("disabled", !0)
                                          .closest(".multiselect-option")
                                          .addClass("disabled")
                                    : $input
                                          .prop("disabled", !1)
                                          .closest(".multiselect-option")
                                          .removeClass("disabled");
                        }, this)
                    ),
                    this.updateButtonText(),
                    this.updateSelectAll(),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups();
            },
            select: function (selectValues, triggerOnChange) {
                $.isArray(selectValues) || (selectValues = [selectValues]);
                for (var i = 0; i < selectValues.length; i++) {
                    var value = selectValues[i];
                    if (null != value) {
                        var $option = this.getOptionByValue(value),
                            $checkbox = this.getInputByValue(value);
                        void 0 !== $option &&
                            void 0 !== $checkbox &&
                            (this.options.multiple || this.deselectAll(!1),
                            this.options.selectedClass &&
                                $checkbox
                                    .closest(".dropdown-item")
                                    .addClass(this.options.selectedClass),
                            $checkbox.prop("checked", !0),
                            $option.prop("selected", !0),
                            triggerOnChange &&
                                this.options.onChange($option, !0));
                    }
                }
                this.updateButtonText(),
                    this.updateSelectAll(),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups();
            },
            clearSelection: function () {
                this.deselectAll(!1),
                    this.updateButtonText(),
                    this.updateSelectAll(),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups();
            },
            deselect: function (deselectValues, triggerOnChange) {
                $.isArray(deselectValues) ||
                    (deselectValues = [deselectValues]);
                for (var i = 0; i < deselectValues.length; i++) {
                    var value = deselectValues[i];
                    if (null != value) {
                        var $option = this.getOptionByValue(value),
                            $checkbox = this.getInputByValue(value);
                        void 0 !== $option &&
                            void 0 !== $checkbox &&
                            (this.options.selectedClass &&
                                $checkbox
                                    .closest(".dropdown-item")
                                    .removeClass(this.options.selectedClass),
                            $checkbox.prop("checked", !1),
                            $option.prop("selected", !1),
                            triggerOnChange &&
                                this.options.onChange($option, !1));
                    }
                }
                this.updateButtonText(),
                    this.updateSelectAll(),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups();
            },
            selectAll: function (justVisible, triggerOnSelectAll) {
                var justVisible = void 0 === justVisible || justVisible,
                    allOptions = $(
                        ".multiselect-option:not(.disabled)",
                        this.$popupContainer
                    ),
                    visibleOptions = $(
                        ".multiselect-option:not(.disabled):not(.multiselect-filter-hidden):not(.multiselect-collapisble-hidden)",
                        this.$popupContainer
                    ).filter(":visible");
                justVisible
                    ? ($("input:enabled", visibleOptions).prop("checked", !0),
                      visibleOptions.addClass(this.options.selectedClass),
                      $("input:enabled", visibleOptions).each(
                          $.proxy(function (index, element) {
                              var value = $(element).val(),
                                  option = this.getOptionByValue(value);
                              $(option).prop("selected", !0);
                          }, this)
                      ))
                    : ($("input:enabled", allOptions).prop("checked", !0),
                      allOptions.addClass(this.options.selectedClass),
                      $("input:enabled", allOptions).each(
                          $.proxy(function (index, element) {
                              var value = $(element).val(),
                                  option = this.getOptionByValue(value);
                              $(option).prop("selected", !0);
                          }, this)
                      )),
                    $(
                        '.multiselect-option input[value="' +
                            this.options.selectAllValue +
                            '"]',
                        this.$popupContainer
                    ).prop("checked", !0),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups(),
                    this.updateButtonText(),
                    this.updateSelectAll(),
                    triggerOnSelectAll && this.options.onSelectAll();
            },
            deselectAll: function (justVisible, triggerOnDeselectAll) {
                var justVisible = void 0 === justVisible || justVisible,
                    allOptions = $(
                        ".multiselect-option:not(.disabled):not(.multiselect-group)",
                        this.$popupContainer
                    ),
                    visibleOptions = $(
                        ".multiselect-option:not(.disabled):not(.multiselect-filter-hidden):not(.multiselect-collapisble-hidden)",
                        this.$popupContainer
                    ).filter(":visible");
                justVisible
                    ? ($('input[type="checkbox"]:enabled', visibleOptions).prop(
                          "checked",
                          !1
                      ),
                      visibleOptions.removeClass(this.options.selectedClass),
                      $('input[type="checkbox"]:enabled', visibleOptions).each(
                          $.proxy(function (index, element) {
                              var value = $(element).val(),
                                  option = this.getOptionByValue(value);
                              $(option).prop("selected", !1);
                          }, this)
                      ))
                    : ($('input[type="checkbox"]:enabled', allOptions).prop(
                          "checked",
                          !1
                      ),
                      allOptions.removeClass(this.options.selectedClass),
                      $('input[type="checkbox"]:enabled', allOptions).each(
                          $.proxy(function (index, element) {
                              var value = $(element).val(),
                                  option = this.getOptionByValue(value);
                              $(option).prop("selected", !1);
                          }, this)
                      )),
                    $(
                        '.multiselect-all input[value="' +
                            this.options.selectAllValue +
                            '"]',
                        this.$popupContainer
                    ).prop("checked", !1),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups(),
                    this.updateButtonText(),
                    this.updateSelectAll(),
                    triggerOnDeselectAll && this.options.onDeselectAll();
            },
            rebuild: function () {
                this.$popupContainer.html(""),
                    (this.options.multiple =
                        "multiple" === this.$select.attr("multiple")),
                    this.buildSelectAll(),
                    this.buildDropdownOptions(),
                    this.buildFilter(),
                    this.updateButtonText(),
                    this.updateSelectAll(!0),
                    this.options.enableClickableOptGroups &&
                        this.options.multiple &&
                        this.updateOptGroups(),
                    this.options.disableIfEmpty &&
                    $("option", this.$select).length <= 0
                        ? this.disable()
                        : this.enable(),
                    this.options.dropRight
                        ? this.$container.addClass("dropright")
                        : this.options.dropUp &&
                          this.$container.addClass("dropup");
            },
            dataprovider: function (dataprovider) {
                var groupCounter = 0,
                    $select = this.$select.empty();
                $.each(dataprovider, function (index, option) {
                    var $tag;
                    if ($.isArray(option.children))
                        groupCounter++,
                            ($tag = $("<optgroup/>").attr({
                                label: option.label || "Group " + groupCounter,
                                disabled: !!option.disabled,
                                value: option.value,
                            })),
                            forEach(option.children, function (subOption) {
                                var attributes = {
                                    value: subOption.value,
                                    label: subOption.label || subOption.value,
                                    title: subOption.title,
                                    selected: !!subOption.selected,
                                    disabled: !!subOption.disabled,
                                };
                                for (var key in subOption.attributes)
                                    attributes["data-" + key] =
                                        subOption.attributes[key];
                                $tag.append($("<option/>").attr(attributes));
                            });
                    else {
                        var attributes = {
                            value: option.value,
                            label: option.label || option.value,
                            title: option.title,
                            class: option.class,
                            selected: !!option.selected,
                            disabled: !!option.disabled,
                        };
                        for (var key in option.attributes)
                            attributes["data-" + key] = option.attributes[key];
                        ($tag = $("<option/>").attr(attributes)).text(
                            option.label || option.value
                        );
                    }
                    $select.append($tag);
                }),
                    this.rebuild();
            },
            enable: function () {
                this.$select.prop("disabled", !1),
                    this.$button.prop("disabled", !1).removeClass("disabled"),
                    this.updateButtonText();
            },
            disable: function () {
                this.$select.prop("disabled", !0),
                    this.$button.prop("disabled", !0).addClass("disabled"),
                    this.updateButtonText();
            },
            setOptions: function (options) {
                this.options = this.mergeOptions(options);
            },
            mergeOptions: function (options) {
                return $.extend(!0, {}, this.defaults, this.options, options);
            },
            hasSelectAll: function () {
                return $(".multiselect-all", this.$popupContainer).length > 0;
            },
            updateOptGroups: function () {
                var $groups = $(".multiselect-group", this.$popupContainer),
                    selectedClass = this.options.selectedClass;
                $groups.each(function () {
                    var $options = $(this)
                            .nextUntil(".multiselect-group")
                            .not(".multiselect-filter-hidden")
                            .not(".disabled"),
                        checked = !0;
                    $options.each(function () {
                        var $input;
                        $("input", this).prop("checked") || (checked = !1);
                    }),
                        selectedClass &&
                            (checked
                                ? $(this).addClass(selectedClass)
                                : $(this).removeClass(selectedClass)),
                        $("input", this).prop("checked", checked);
                });
            },
            updateSelectAll: function (notTriggerOnSelectAll) {
                if (this.hasSelectAll()) {
                    var allBoxes = $(
                            ".multiselect-option:not(.multiselect-filter-hidden):not(.multiselect-group):not(.disabled) input:enabled",
                            this.$popupContainer
                        ),
                        allBoxesLength = allBoxes.length,
                        checkedBoxesLength = allBoxes.filter(":checked").length,
                        selectAllItem = $(
                            ".multiselect-all",
                            this.$popupContainer
                        ),
                        selectAllInput = selectAllItem.find("input");
                    checkedBoxesLength > 0 &&
                    checkedBoxesLength === allBoxesLength
                        ? (selectAllInput.prop("checked", !0),
                          selectAllItem.addClass(this.options.selectedClass))
                        : (selectAllInput.prop("checked", !1),
                          selectAllItem.removeClass(
                              this.options.selectedClass
                          ));
                }
            },
            updateButtonText: function () {
                var options = this.getSelected();
                this.options.enableHTML
                    ? $(
                          ".multiselect .multiselect-selected-text",
                          this.$container
                      ).html(this.options.buttonText(options, this.$select))
                    : $(
                          ".multiselect .multiselect-selected-text",
                          this.$container
                      ).text(this.options.buttonText(options, this.$select)),
                    $(".multiselect", this.$container).attr(
                        "title",
                        this.options.buttonTitle(options, this.$select)
                    );
            },
            getSelected: function () {
                return $("option", this.$select).filter(":selected");
            },
            getOptionByValue: function (value) {
                for (
                    var options = $("option", this.$select),
                        valueToCompare = value.toString(),
                        i = 0;
                    i < options.length;
                    i += 1
                ) {
                    var option = options[i];
                    if (option.value === valueToCompare) return $(option);
                }
            },
            getInputByValue: function (value) {
                for (
                    var checkboxes = $(
                            ".multiselect-option input:not(.multiselect-search)",
                            this.$popupContainer
                        ),
                        valueToCompare = value.toString(),
                        i = 0;
                    i < checkboxes.length;
                    i += 1
                ) {
                    var checkbox = checkboxes[i];
                    if (checkbox.value === valueToCompare) return $(checkbox);
                }
            },
            updateOriginalOptions: function () {
                this.originalOptions = this.$select.clone()[0].options;
            },
            asyncFunction: function (callback, timeout, self) {
                var args = Array.prototype.slice.call(arguments, 3);
                return setTimeout(function () {
                    callback.apply(self || window, args);
                }, timeout);
            },
            setAllSelectedText: function (allSelectedText) {
                (this.options.allSelectedText = allSelectedText),
                    this.updateButtonText();
            },
            isFirefox: function () {
                var firefoxIdentifier = "firefox",
                    valueNotFoundIndex = -1;
                return (
                    !(!navigator || !navigator.userAgent) &&
                    navigator.userAgent.toLocaleLowerCase().indexOf("firefox") >
                        -1
                );
            },
        }),
        ($.fn.multiselect = function (option, parameter, extraOptions) {
            return this.each(function () {
                var data = $(this).data("multiselect"),
                    options;
                data ||
                    ((data = new Multiselect(
                        this,
                        "object" == typeof option && option
                    )),
                    $(this).data("multiselect", data)),
                    "string" == typeof option &&
                        (data[option](parameter, extraOptions),
                        "destroy" === option &&
                            $(this).data("multiselect", !1));
            });
        }),
        ($.fn.multiselect.Constructor = Multiselect),
        $(function () {
            $("select[data-role=multiselect]").multiselect();
        });
});
