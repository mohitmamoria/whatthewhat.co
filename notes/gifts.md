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

Claiming process:

/gifts/GIFT

Click on 'receive one book'

Simple OTP-based auth system

Logged in player:

- If already has a gift, sorry, you already have received a gift before
- If available, show CLAIM button with a warning that they have 5 minutes to complete the transaction.
- When CLAIM pressed. Reserve a code and send them to the /gifts/GIFT/codes/CODE URL.
- Create a cart with attributes: [GIFTCODE = GIFTCODENAME]

Webhook

- Record activity. WTW_GIFT_RECEIVED for the receiver.
