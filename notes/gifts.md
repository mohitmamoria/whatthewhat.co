gifts

CLAIM URL: /gifts/{NAME}

- id
- name (unique; auto generated)
- gifter_id
- variant (with shipping, without shipping)
- quantity (10, 20)
- created_at
- updated_at
- deleted_at

gift_codes

INDIVIDUALL CLAIM URL: /gifts/{GIFTNAME}/codes/{CODENAME}

- id
- gift_id
- name (unique; auto generated)
- code (r4riuewr)
- status (unclaimed, reserved, claimed)
- claimant_id (nullable; added when reserved and claimed; unset when moved to unclaimed)
- shopify_id (nullable; populate when gift card created on shopify)
- meta ({shopify_order_id: xxx})
- reserved_at
- created_at
- updated_at
- deleted_at
