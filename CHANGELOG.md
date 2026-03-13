# Changelog

All notable changes to this project will be documented in this file.

---

## 1.0.1

Initial public release.

### Added

- injection of `{product_reference}` variable
- support for product combinations
- hook `actionUpdateQuantity`
- hook `sendMailAlterTemplateVars`
- context cleanup to prevent reference leak
- defensive checks on template variables

### Technical

- no override
- no core modification
- no change to `ps_emailalerts`
- compatible with PrestaShop 1.7 / 8
