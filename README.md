# HideJoinMessage

Tired of join/leave spam in chat? This plugin lets you hide them completely or replace them with your own messages.

## Features

- Hide join and leave messages independently
- Replace them with custom messages instead of removing completely
- Private welcome message only the joining player sees
- Op exception — let specific players keep their messages visible
- `/hj reload` to reload config without restarting the server

## Installation

Drop the `.phar` file into your `plugins/` folder and restart the server. That's it.

## Config

```yaml
# whether to hide the join message
hide-join-message: true
# custom join message | empty = hide completely | {player} = player name
custom-join-message: ""

# whether to hide the leave message
hide-leave-message: true
# custom leave message | empty = hide completely | {player} = player name
custom-leave-message: ""

# if true, players with hidejoinmessage.see permission will still show their messages
op-exception: false

# welcome message sent only to the joining player
private-welcome:
  enabled: true
  message: "§aWelcome §e{player}§a!"
```

## Commands

| Command | Description | Permission |
|---|---|---|
| `/hj reload` | Reloads the config | `hidejoinmessage.reload` |

## Permissions

| Permission | Description | Default |
|---|---|---|
| `hidejoinmessage.reload` | Access to `/hj reload` | op |
| `hidejoinmessage.see` | Keep your messages visible when op-exception is on | op |
