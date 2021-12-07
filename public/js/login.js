"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["login"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Login',
  props: {
    otp: {
      type: Number,
      "default": 4
    },
    timer: {
      type: Number,
      "default": 60
    }
  },
  data: function data() {
    return {
      busy: false,
      busyResend: false,
      timerCount: this.timer,
      timerEnabled: false,
      formPhone: true,
      formPassword: false,
      formOtp: false,
      form: {
        phone: null,
        password: null,
        otp: null,
        state: null
      }
    };
  },
  watch: {
    timerEnabled: function timerEnabled(value) {
      var _this = this;

      if (value) {
        setTimeout(function () {
          _this.timerCount--;
        }, 1000);
      }
    },
    timerCount: {
      handler: function handler(value) {
        var _this2 = this;

        if (value > 0 && this.timerEnabled) {
          setTimeout(function () {
            _this2.timerCount--;
          }, 1000);
        } else {
          this.timerEnabled = false;
          this.timerCount = this.timer;
        }
      },
      immediate: true
    }
  },
  methods: {
    completeOtp: function completeOtp(value) {
      this.form.otp = value;
      console.log(this.form.otp);
    },
    forgot: function forgot() {
      var _this3 = this;

      this.busyResend = true;
      setTimeout(function () {
        _this3.$store.dispatch('sendOtp', _this3.form).then(function (res) {
          _this3.pushToast('success', res.data.message);
        })["catch"](function (err) {
          _this3.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
        })["finally"](function (res) {
          _this3.formPassword = false;
          _this3.formOtp = true;
          _this3.busyResend = false;
          _this3.form.state = 'forgot-password';
          setTimeout(function () {
            _this3.timerEnabled = true;
          }, 200);
        });
      }, 500);
    },
    resend: function resend() {
      var _this4 = this;

      this.busyResend = true;
      setTimeout(function () {
        _this4.$store.dispatch('sendOtp', _this4.form).then(function (res) {
          _this4.pushToast('success', res.data.message);

          setTimeout(function () {
            _this4.timerEnabled = true;
          }, 200);
        })["catch"](function (err) {
          _this4.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
        })["finally"](function (res) {
          _this4.busyResend = false;
        });
      }, 500);
    },
    submitOtp: function submitOtp() {
      var _this5 = this;

      this.$validator.validateAll().then(function (result) {
        if (!result) return;
        _this5.busy = true;
        setTimeout(function () {
          _this5.$store.dispatch('checkOtp', _this5.form).then(function (res) {
            _this5.formOtp = false;
            _this5.formPassword = true;
          })["catch"](function (err) {
            _this5.pushToast('danger', err.data.error || err.data.errors.otp[0] || err.data.message);
          })["finally"](function (res) {
            _this5.busy = false;
          });
        }, 500);
      });
    },
    submitPassword: function submitPassword() {
      var _this6 = this;

      this.$validator.validateAll().then(function (result) {
        if (!result) return;
        _this6.busy = true;
        setTimeout(function () {
          _this6.$store.dispatch('login', _this6.form).then(function (res) {
            _this6.$router.push(_this6.$route.query.redirect || {
              name: 'account'
            });
          })["catch"](function (err) {
            _this6.pushToast('danger', err.data.error || err.data.errors.password[0] || err.data.message);
          })["finally"](function (res) {
            _this6.busy = false;
          });
        }, 500);
      });
    },
    submitPhone: function submitPhone() {
      var _this7 = this;

      this.$validator.validateAll().then(function (result) {
        if (!result) return;
        _this7.busy = true;
        setTimeout(function () {
          _this7.$store.dispatch('checkLogin', _this7.form).then(function (res) {
            _this7.formPhone = false;

            if (res.data.otp) {
              _this7.formOtp = true;
              _this7.timerEnabled = true;
              _this7.form.state = 'register';

              _this7.pushToast('success', res.data.message);
            } else {
              _this7.formPassword = true;
            }
          })["catch"](function (err) {
            _this7.pushToast('danger', err.data.error || err.data.errors.phone[0] || err.data.message);
          })["finally"](function (res) {
            _this7.busy = false;
          });
        }, 500);
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/pages/Login.vue":
/*!**************************************!*\
  !*** ./resources/js/pages/Login.vue ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=3b6adb30& */ "./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30&");
/* harmony import */ var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ "./resources/js/pages/Login.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__.render,
  _Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Login.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Login.vue?vue&type=script&lang=js&":
/*!***************************************************************!*\
  !*** ./resources/js/pages/Login.vue?vue&type=script&lang=js& ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30&":
/*!*********************************************************************!*\
  !*** ./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30& ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_3b6adb30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Login.vue?vue&type=template&id=3b6adb30& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Login.vue?vue&type=template&id=3b6adb30& ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "LoginPage_page height-control overflow-hidden" },
    [
      _vm.formPhone
        ? _c("div", { staticClass: "animated LoginPage_formBody" }, [
            _c("div", { staticClass: "detailsHdrBody LoginPage_detailsBody" }, [
              _c("img", {
                staticStyle: { padding: "10px" },
                attrs: { src: "media/image/login-page.png", width: "200" },
              }),
              _vm._v(" "),
              _c("div", { staticClass: "LoginPage_text LoginPage_formTitle" }, [
                _vm._v("Masukkan nomor WhatsApp Anda"),
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "LoginPage_form" },
                [
                  _c(
                    "b-form",
                    {
                      on: {
                        submit: function ($event) {
                          $event.stopPropagation()
                          $event.preventDefault()
                          return _vm.submitPhone.apply(null, arguments)
                        },
                      },
                    },
                    [
                      _c("b-form-input", {
                        directives: [
                          {
                            name: "validate",
                            rawName: "v-validate",
                            value: {
                              required: true,
                              min: 10,
                              max: 13,
                              regex: /(08)[0-9]{8}/,
                            },
                            expression:
                              "{ required: true, min:10, max:13, regex:/(08)[0-9]{8}/ }",
                          },
                        ],
                        staticClass: "LoginForm_phone",
                        attrs: {
                          name: "phone",
                          type: "number",
                          placeholder: "08xxx",
                          state: _vm.validateState("phone"),
                          "data-vv-as": "Whatsapp",
                        },
                        on: { keypress: _vm.numberOnly },
                        model: {
                          value: _vm.form.phone,
                          callback: function ($$v) {
                            _vm.$set(_vm.form, "phone", $$v)
                          },
                          expression: "form.phone",
                        },
                      }),
                      _vm._v(" "),
                      _c("b-form-invalid-feedback", [
                        _vm._v(_vm._s(_vm.veeErrors.first("phone"))),
                      ]),
                      _vm._v(" "),
                      _c(
                        "b-overlay",
                        {
                          staticClass: "LoginForm_submitBtn",
                          attrs: {
                            show: _vm.busy,
                            opacity: "0.7",
                            "spinner-small": "",
                            "spinner-variant": "success",
                          },
                        },
                        [
                          _c(
                            "b-button",
                            {
                              staticClass: "btn btn-primary",
                              attrs: {
                                disabled: _vm.busy,
                                block: "",
                                variant: "primary",
                                type: "submit",
                              },
                            },
                            [_vm._v("Lanjut")]
                          ),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
            ]),
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.formPassword
        ? _c("div", { staticClass: "LoginPage_formBody" }, [
            _c(
              "div",
              { staticClass: "animated detailsHdrBody LoginPage_detailsBody" },
              [
                _c(
                  "div",
                  { staticClass: "LoginPage_text LoginPage_formTitle" },
                  [_vm._v("Masukkan kata sandi")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "LoginPage_formInfo" }, [
                  _vm._v("Kata sandi dibutuhkan untuk keamanan akun Anda"),
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "LoginPage_form" },
                  [
                    _c(
                      "b-form",
                      {
                        on: {
                          submit: function ($event) {
                            $event.stopPropagation()
                            $event.preventDefault()
                            return _vm.submitPassword.apply(null, arguments)
                          },
                        },
                      },
                      [
                        _c("b-form-input", {
                          directives: [
                            {
                              name: "validate",
                              rawName: "v-validate",
                              value: { required: true, min: 6 },
                              expression: "{ required: true, min:6 }",
                            },
                          ],
                          staticClass: "LoginForm_phone",
                          attrs: {
                            name: "password",
                            type: "password",
                            state: _vm.validateState("password"),
                            "data-vv-as": "Password",
                          },
                          model: {
                            value: _vm.form.password,
                            callback: function ($$v) {
                              _vm.$set(_vm.form, "password", $$v)
                            },
                            expression: "form.password",
                          },
                        }),
                        _vm._v(" "),
                        _c("b-form-invalid-feedback", [
                          _vm._v(_vm._s(_vm.veeErrors.first("password"))),
                        ]),
                        _vm._v(" "),
                        _c(
                          "b-overlay",
                          {
                            attrs: {
                              show: _vm.busyResend,
                              opacity: "0.7",
                              "spinner-small": "",
                              "spinner-variant": "success",
                            },
                          },
                          [
                            _c("div", { staticClass: "PinForm_forgotPin" }, [
                              _vm._v("Lupa kata sandi Anda? "),
                              _c(
                                "a",
                                {
                                  attrs: {
                                    href: "#",
                                    disabled: _vm.busyResend,
                                  },
                                  on: {
                                    click: function ($event) {
                                      return _vm.forgot()
                                    },
                                  },
                                },
                                [_vm._v("Klik disini")]
                              ),
                              _vm._v(" untuk verifikasi ulang"),
                            ]),
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "b-overlay",
                          {
                            staticClass: "LoginForm_submitBtn",
                            attrs: {
                              show: _vm.busy,
                              opacity: "0.7",
                              "spinner-small": "",
                              "spinner-variant": "success",
                            },
                          },
                          [
                            _c(
                              "b-button",
                              {
                                staticClass: "btn btn-primary",
                                attrs: {
                                  disabled: _vm.busy,
                                  block: "",
                                  variant: "primary",
                                  type: "submit",
                                },
                              },
                              [_vm._v("Konfirmasi")]
                            ),
                          ],
                          1
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                ),
              ]
            ),
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.formOtp
        ? _c("div", { staticClass: "animated LoginPage_formBody" }, [
            _c("div", { staticClass: "detailsHdrBody OtpPage_detailsBody" }, [
              _c("div", { staticClass: "OtpPage_formTitle" }, [
                _vm._v("Masukkan kode OTP"),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "OtpPage_formInfo" }, [
                _vm._v(
                  "Untuk memastikan ini Anda, ayo masukkan kode verifikasi yang telah kami kirim ke "
                ),
                _c("span", {
                  staticClass: "OtpPage_boldText",
                  domProps: { textContent: _vm._s(_vm.form.phone) },
                }),
                _vm._v(" via "),
                _c("span", { staticClass: "OtpPage_boldText" }, [
                  _vm._v("WhatsApp"),
                ]),
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "OtpPage_formInput" },
                [
                  _c(
                    "b-form",
                    {
                      on: {
                        submit: function ($event) {
                          $event.stopPropagation()
                          $event.preventDefault()
                          return _vm.submitOtp.apply(null, arguments)
                        },
                      },
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "OtpForm_otpInputAndResendDiv" },
                        [
                          _c("div", { staticClass: "OtpForm_otpInputDi" }, [
                            _c(
                              "div",
                              {
                                staticClass: "OtpForm_otpContainer",
                                staticStyle: { display: "flex" },
                              },
                              [
                                _c(
                                  "div",
                                  {
                                    staticStyle: {
                                      display: "flex",
                                      "align-items": "center",
                                    },
                                  },
                                  [
                                    _c("v-otp-input", {
                                      ref: "otpInput",
                                      attrs: {
                                        "input-classes": "OtpForm_otpInput",
                                        separator: "",
                                        "num-inputs": 4,
                                        "should-auto-focus": true,
                                        "is-input-num": true,
                                      },
                                      on: { "on-complete": _vm.completeOtp },
                                    }),
                                  ],
                                  1
                                ),
                              ]
                            ),
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "OtpForm_resendOtp" }, [
                            _vm._v("Tidak menerima kode verifikasi?"),
                          ]),
                          _vm._v(" "),
                          _vm.timerEnabled
                            ? _c("div", { staticClass: "OtpForm_resendOtp" }, [
                                _vm._v("Mohon tunggu "),
                                _c(
                                  "span",
                                  { staticClass: "OtpForm_countdown" },
                                  [_vm._v(_vm._s(_vm.timerCount))]
                                ),
                                _vm._v(" detik untuk kirim ulang"),
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          _c(
                            "b-overlay",
                            {
                              attrs: {
                                show: _vm.busyResend,
                                opacity: "0.7",
                                "spinner-small": "",
                                "spinner-variant": "success",
                              },
                            },
                            [
                              !_vm.timerEnabled
                                ? _c(
                                    "div",
                                    {
                                      staticClass:
                                        "OtpForm_resendOtp OtpForm_resendOtpBtn OtpForm_whatsappResend",
                                      attrs: { disabled: _vm.busyResend },
                                      on: {
                                        click: function ($event) {
                                          return _vm.resend()
                                        },
                                      },
                                    },
                                    [_vm._v("KIRIM ULANG VIA WHATSAPP")]
                                  )
                                : _vm._e(),
                            ]
                          ),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-overlay",
                        {
                          staticClass: "LoginForm_submitBtn",
                          attrs: {
                            show: _vm.busy,
                            opacity: "0.7",
                            "spinner-small": "",
                            "spinner-variant": "success",
                          },
                        },
                        [
                          _c(
                            "b-button",
                            {
                              staticClass: "btn btn-primary",
                              attrs: {
                                disabled: _vm.busy,
                                block: "",
                                variant: "primary",
                                type: "submit",
                              },
                            },
                            [_vm._v("Konfirmasi")]
                          ),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
            ]),
          ])
        : _vm._e(),
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);