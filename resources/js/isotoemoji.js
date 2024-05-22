function isoToEmoji (code) {
    return code
        .split('')
        .map(letter => letter.charCodeAt(0) % 32 + 0x1F1E5)
        .map(emojiCode => String.fromCodePoint(emojiCode))
        .join('')
}
