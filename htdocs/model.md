# DB Model

- users
    - username
    - password_hash
    - email
    - ID
    - display_name

- events
    - ID
    - title
    - slug
    - location

- pots
    - ID
    - title
    - slug
    - amount
    - num_people
    - status
    - currency
    - event_id

- spendings
    - ID
    - amount
    - description
    - date
    - author
    - pot_id

- pot_members
    - pot_id
    - user_id
    - weight

- spendings_people
    - spending_id
    - user_id
