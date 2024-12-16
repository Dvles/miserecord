<?php

namespace App\Enum;

enum ProducerRolesEnum: string
{
    case PRODUCER = 'producer';
    case SONGWRITER = 'songwriter';
    case MIXING_ENGINEER = 'mixing_engineer';
    case MASTERING_ENGINEER = 'mastering_engineer';
    case RECORDING_ENGINEER = 'recording_engineer';
    case ARRANGER = 'arranger';
    case COMPOSER = 'composer';
    case CO_PRODUCER = 'co_producer';
    case LYRICIST = 'lyricist';
    case SOUND_DESIGNER = 'sound_designer';
    case VOCAL_PRODUCER = 'vocal_producer';
    case INSTRUMENTALIST = 'instrumentalist';
    case PRODUCTION_MANAGER = 'production_manager';
    case SESSION_MUSICIANS = 'session_musicians';
}
