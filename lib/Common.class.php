<?php

class Common {
    /**
     * debug and die
     *
     * @param $data
     */
    public static function debug($data) {
        echo '<pre>';
        print_r($data);
        exit;
    }

    /**
     * debug and no die
     *
     * @param $data
     */
    public static function debugNoDie($data) {
        echo '<pre>';
        print_r($data);
    }

    /**
     * 字符串加解密
     *
     * @param string $dataString 待加解密字符串
     * @param bool $isEncryption 是否加密
     * @return string 处理后结果
     */
    public static function stringChange($dataString = '', $isEncryption = true, &$flag = false) {
        $charCodeTop = 126;
        $charCodeBottom = 33;
        $stepTop = 33;
        $stepBottom = 1;
        $charCodeArray = array();
        if (true === $isEncryption) {
            for ($cnt = $charCodeBottom; $cnt < $charCodeTop ; $cnt++) {
                $charCodeArray[$cnt]['f'] = $cnt - 1;
                $charCodeArray[$cnt]['b'] = $cnt + 1;
            }
            $charCodeArray[$charCodeBottom]['f'] = $charCodeTop;
            $charCodeArray[$charCodeTop]['f'] = $charCodeTop - 1;
            $charCodeArray[$charCodeTop]['b'] = $charCodeBottom;
        } else {
            for ($cnt = $charCodeBottom; $cnt < $charCodeTop ; $cnt++) {
                $charCodeArray[$cnt]['f'] = $cnt + 1;
                $charCodeArray[$cnt]['b'] = $cnt - 1;
            }
            $charCodeArray[$charCodeBottom]['b'] = $charCodeTop;
            $charCodeArray[$charCodeTop]['b'] = $charCodeTop - 1;
            $charCodeArray[$charCodeTop]['f'] = $charCodeBottom;
        }
        $supportDirectionArray = array(
            'f' => 'front',
            'b' => 'back',
        );
        $tmpDataString = trim($dataString);
        $returnStr = $tmpDataString;
        $tmpDataArray = str_split($tmpDataString, 1);
        if (empty($tmpDataArray) || 3 >= count($tmpDataArray)) {
            $flag = false;
            return $returnStr;
        } else {
            $step = intval($tmpDataArray[1]);
            if ($step < $stepBottom || $step > $stepTop) {
                $flag = false;
                return $returnStr;
            }
            $directTag = $tmpDataArray[2];
            if (!isset($supportDirectionArray[$directTag])) {
                $flag = false;
                return $returnStr;
            }
            $tmpArray = array();
            foreach ($tmpDataArray as $key => $char) {
                if (0 == $key || 1 == $key || 2 == $key) {
                    $tmpArray[$key] = $char;
                } else {
                    $tmpCharCode = ord($char);
                    if (!isset($charCodeArray[$tmpCharCode])) {
                        $tmpArray[$key] = $char;
                    } else {
                        $resultCharCode = $tmpCharCode;
                        for ($i = 1; $i <= $step; $i++) {
                            $resultCharCode = $charCodeArray[$resultCharCode][$directTag];
                        }
                        $tmpArray[$key] = chr($resultCharCode);
                    }
                }
            }
            $returnStr = implode('', $tmpArray);
            $flag = true;
            return $returnStr;
        }
    }

    /**
     * 获取加密公用前缀
     *
     * @return string
     */
    public static function obtainEncryptionPrefix() {
        $top = 9;
        $bottom = 1;
        $default = 5;
        $supportDirectionArray = array(
            0 => 'f',
            1 => 'b',
        );
        $tmp = intval(mt_rand($bottom, $top));
        if ($tmp < $bottom || $tmp > $top) {
            $tmp = intval($default);
        }
        $times = $tmp;
        $tmp = intval(mt_rand($bottom, $top));
        if ($tmp < $bottom || $tmp > $top) {
            $tmp = intval($default);
        }
        $step = $tmp;
        $tmp = intval(mt_rand(0, 1));
        $direct = 'f';
        if (isset($supportDirectionArray[$tmp])) {
            $direct = $supportDirectionArray[$tmp];
        } else {
            // do nothing
        }
        $returnStr = "{$times}{$step}{$direct}";
        return  $returnStr;
    }

    /**
     * 加密字符串
     *
     * @param string $dataString
     * @return string
     */
    public static function encryptString($dataString = '') {
        $returnStr = trim($dataString);
        if (empty($returnStr)) {
            return $returnStr;
        } else {
            $returnStr = self::obtainEncryptionPrefix() . $returnStr;
            $cnt = intval(substr($returnStr, 0, 1));
            for ($i = 1; $i <= $cnt; $i++) {
                $returnStr = self::stringChange($returnStr, true);
            }
            return $returnStr;
        }
    }

    /**
     * 解密字符串
     *
     * @param string $dataString
     * @return string
     */
    public static function decryptString($dataString = '') {
        $returnStr = trim($dataString);
        if (empty($returnStr)) {
            return $returnStr;
        } else {
            $cnt = intval(substr($returnStr, 0, 1));
            $flag = false;
            for ($i = 1; $i <= $cnt; $i++) {
                $returnStr = self::stringChange($returnStr, false, $flag);
            }
            if (true === $flag) {
                $returnStr = substr($returnStr, 3);
            } else {
                // do nothing
            }
            return $returnStr;
        }
    }

    /**
     * 获取顶级域名数组
     *
     * @return array
     */
    public static function obtainTopDomain() {
        $topDomainArray = array(
            'com', 'net','org','gov','mobi','info','biz','cc',
            'tv','asia','me','travel','tel','name','co','so',
            'au','uk','ca','cn',
            );
        return $topDomainArray;
    }

    /**
     * 获取国家编码列表
     *
     * @return array
     */
    public static function obtainCountryCodeList() {
        $returnArray = array(
            'ad' => 'and', 'and' => 'and', 20 => 'and',
            'ae' => 'are', 'are' => 'are', 784 => 'are',
            'af' => 'afg', 'afg' => 'afg', 4 => 'afg',
            'ag' => 'atg', 'atg' => 'atg', 28 => 'atg',
            'ai' => 'aia', 'aia' => 'aia', 660 => 'aia',
            'al' => 'alb', 'alb' => 'alb', 8 => 'alb',
            'am' => 'arm', 'arm' => 'arm', 51 => 'arm',
            'ao' => 'ago', 'ago' => 'ago', 24 => 'ago',
            'aq' => 'ata', 'ata' => 'ata', 10 => 'ata',
            'ar' => 'arg', 'arg' => 'arg', 32 => 'arg',
            'as' => 'asm', 'asm' => 'asm', 16 => 'asm',
            'at' => 'aut', 'aut' => 'aut', 40 => 'aut',
            'au' => 'aus', 'aus' => 'aus', 36 => 'aus',
            'aw' => 'abw', 'abw' => 'abw', 533 => 'abw',
            'ax' => 'ala', 'ala' => 'ala', 248 => 'ala',
            'az' => 'aze', 'aze' => 'aze', 31 => 'aze',
            'ba' => 'bih', 'bih' => 'bih', 70 => 'bih',
            'bb' => 'brb', 'brb' => 'brb', 52 => 'brb',
            'bd' => 'bgd', 'bgd' => 'bgd', 50 => 'bgd',
            'be' => 'bel', 'bel' => 'bel', 56 => 'bel',
            'bf' => 'bfa', 'bfa' => 'bfa', 854 => 'bfa',
            'bg' => 'bgr', 'bgr' => 'bgr', 100 => 'bgr',
            'bh' => 'bhr', 'bhr' => 'bhr', 48 => 'bhr',
            'bi' => 'bdi', 'bdi' => 'bdi', 108 => 'bdi',
            'bj' => 'ben', 'ben' => 'ben', 204 => 'ben',
            'bl' => 'blm', 'blm' => 'blm', 652 => 'blm',
            'bm' => 'bmu', 'bmu' => 'bmu', 60 => 'bmu',
            'bn' => 'brn', 'brn' => 'brn', 96 => 'brn',
            'bo' => 'bol', 'bol' => 'bol', 68 => 'bol',
            'bq' => 'bes', 'bes' => 'bes', 535 => 'bes',
            'br' => 'bra', 'bra' => 'bra', 76 => 'bra',
            'bs' => 'bhs', 'bhs' => 'bhs', 44 => 'bhs',
            'bt' => 'btn', 'btn' => 'btn', 64 => 'btn',
            'bv' => 'bvt', 'bvt' => 'bvt', 74 => 'bvt',
            'bw' => 'bwa', 'bwa' => 'bwa', 72 => 'bwa',
            'by' => 'blr', 'blr' => 'blr', 112 => 'blr',
            'bz' => 'blz', 'blz' => 'blz', 84 => 'blz',
            'ca' => 'can', 'can' => 'can', 124 => 'can',
            'cc' => 'cck', 'cck' => 'cck', 166 => 'cck',
            'cd' => 'cod', 'cod' => 'cod', 180 => 'cod',
            'cg' => 'cog', 'cog' => 'cog', 178 => 'cog',
            'cf' => 'caf', 'caf' => 'caf', 140 => 'caf',
            'ch' => 'che', 'che' => 'che', 756 => 'che',
            'ci' => 'civ', 'civ' => 'civ', 384 => 'civ',
            'ck' => 'cok', 'cok' => 'cok', 184 => 'cok',
            'cl' => 'chl', 'chl' => 'chl', 152 => 'chl',
            'cm' => 'cmr', 'cmr' => 'cmr', 120 => 'cmr',
            'cn' => 'chn', 'chn' => 'chn', 156 => 'chn',
            'co' => 'col', 'col' => 'col', 170 => 'col',
            'cr' => 'cri', 'cri' => 'cri', 188 => 'cri',
            'cu' => 'cub', 'cub' => 'cub', 192 => 'cub',
            'cv' => 'cpv', 'cpv' => 'cpv', 132 => 'cpv',
            'cx' => 'cxr', 'cxr' => 'cxr', 162 => 'cxr',
            'cy' => 'cyp', 'cyp' => 'cyp', 192 => 'cyp',
            'cz' => 'cze', 'cze' => 'cze', 203 => 'cze',
            'de' => 'deu', 'deu' => 'deu', 276 => 'deu',
            'dj' => 'dji', 'dji' => 'dji', 262 => 'dji',
            'dk' => 'dnk', 'dnk' => 'dnk', 208 => 'dnk',
            'dm' => 'dma', 'dma' => 'dma', 212 => 'dma',
            'do' => 'dom', 'dom' => 'dom', 214 => 'dom',
            'dz' => 'dza', 'dza' => 'dza', 12 => 'dza',
            'ec' => 'ecu', 'ecu' => 'ecu', 218 => 'ecu',
            'ee' => 'est', 'est' => 'est', 233 => 'est',
            'eg' => 'egy', 'egy' => 'egy', 818 => 'egy',
            'eh' => 'esh', 'esh' => 'esh', 732 => 'esh',
            'er' => 'eri', 'eri' => 'eri', 232 => 'eri',
            'es' => 'esp', 'esp' => 'esp', 724 => 'esp',
            'et' => 'eth', 'eth' => 'eth', 231 => 'eth',
            'fi' => 'fin', 'fin' => 'fin', 246 => 'fin',
            'fj' => 'fji', 'fji' => 'fji', 242 => 'fji',
            'fk' => 'flk', 'flk' => 'flk', 238 => 'flk',
            'fm' => 'fsm', 'fsm' => 'fsm', 583 => 'fsm',
            'fo' => 'fro', 'fro' => 'fro', 234 => 'fro',
            'fr' => 'fra', 'fra' => 'fra', 250 => 'fra',
            'ga' => 'gab', 'gab' => 'gab', 266 => 'gab',
            'gb' => 'gbr', 'gbr' => 'gbr', 826 => 'gbr',
            'gd' => 'grd', 'grd' => 'grd', 308 => 'grd',
            'ge' => 'geo', 'geo' => 'geo', 268 => 'geo',
            'gf' => 'guf', 'guf' => 'guf', 254 => 'guf',
            'gg' => 'ggy', 'ggy' => 'ggy', 831 => 'ggy',
            'gh' => 'gha', 'gha' => 'gha', 288 => 'gha',
            'gi' => 'gib', 'gib' => 'gib', 292 => 'gib',
            'gl' => 'grl', 'grl' => 'grl', 304 => 'grl',
            'gm' => 'gmb', 'gmb' => 'gmb', 270 => 'gmb',
            'gn' => 'gin', 'gin' => 'gin', 324 => 'gin',
            'gp' => 'glp', 'glp' => 'glp', 312 => 'glp',
            'gq' => 'gnq', 'gnq' => 'gnq', 226 => 'gnq',
            'gr' => 'grc', 'grc' => 'grc', 300 => 'grc',
            'gs' => 'sgs', 'sgs' => 'sgs', 239 => 'sgs',
            'gt' => 'gtm', 'gtm' => 'gtm', 320 => 'gtm',
            'gu' => 'gum', 'gum' => 'gum', 316 => 'gum',
            'gw' => 'gnb', 'gnb' => 'gnb', 624 => 'gnb',
            'gy' => 'guy', 'guy' => 'guy', 328 => 'guy',
            'hk' => 'hkg', 'hkg' => 'hkg', 344 => 'hkg',
            'hm' => 'hmd', 'hmd' => 'hmd', 334 => 'hmd',
            'hn' => 'hnd', 'hnd' => 'hnd', 340 => 'hnd',
            'hr' => 'hrv', 'hrv' => 'hrv', 191 => 'hrv',
            'ht' => 'hti', 'hti' => 'hti', 332 => 'hti',
            'hu' => 'hun', 'hun' => 'hun', 348 => 'hun',
            'id' => 'idn', 'idn' => 'idn', 360 => 'idn',
            'ie' => 'irl', 'irl' => 'irl', 372 => 'irl',
            'il' => 'isr', 'isr' => 'isr', 376 => 'isr',
            'im' => 'imn', 'imn' => 'imn', 833 => 'imn',
            'in' => 'ind', 'ind' => 'ind', 356 => 'ind',
            'io' => 'iot', 'iot' => 'iot', 86 => 'iot',
            'iq' => 'irq', 'irq' => 'irq', 368 => 'irq',
            'ir' => 'irn', 'irn' => 'irn', 364 => 'irn',
            'is' => 'isl', 'isl' => 'isl', 352 => 'isl',
            'it' => 'ita', 'ita' => 'ita', 380 => 'ita',
            'je' => 'jey', 'jey' => 'jey', 832 => 'jey',
            'jm' => 'jam', 'jam' => 'jam', 388 => 'jam',
            'jo' => 'jor', 'jor' => 'jor', 400 => 'jor',
            'jp' => 'jpn', 'jpn' => 'jpn', 392 => 'jpn',
            'ke' => 'ken', 'ken' => 'ken', 404 => 'ken',
            'kg' => 'kgz', 'kgz' => 'kgz', 417 => 'kgz',
            'kh' => 'khm', 'khm' => 'khm', 116 => 'khm',
            'ki' => 'kir', 'kir' => 'kir', 296 => 'kir',
            'km' => 'com', 'com' => 'com', 174 => 'com',
            'kn' => 'kna', 'kna' => 'kna', 659 => 'kna',
            'kp' => 'prk', 'prk' => 'prk', 408 => 'prk',
            'kr' => 'kor', 'kor' => 'kor', 410 => 'kor',
            'kw' => 'kwt', 'kwt' => 'kwt', 414 => 'kwt',
            'ky' => 'cym', 'cym' => 'cym', 136 => 'cym',
            'kz' => 'kaz', 'kaz' => 'kaz', 398 => 'kaz',
            'la' => 'lao', 'lao' => 'lao', 418 => 'lao',
            'lc' => 'lca', 'lca' => 'lca', 662 => 'lca',
            'lb' => 'lbn', 'lbn' => 'lbn', 422 => 'lbn',
            'li' => 'lie', 'lie' => 'lie', 438 => 'lie',
            'lk' => 'lka', 'lka' => 'lka', 144 => 'lka',
            'lr' => 'lbr', 'lbr' => 'lbr', 430 => 'lbr',
            'ls' => 'lso', 'lso' => 'lso', 426 => 'lso',
            'lt' => 'ltu', 'ltu' => 'ltu', 440 => 'ltu',
            'lu' => 'lux', 'lux' => 'lux', 442 => 'lux',
            'lv' => 'lva', 'lva' => 'lva', 428 => 'lva',
            'ly' => 'lby', 'lby' => 'lby', 434 => 'lby',
            'ma' => 'mar', 'mar' => 'mar', 504 => 'mar',
            'mc' => 'mco', 'mco' => 'mco', 492 => 'mco',
            'md' => 'mda', 'mda' => 'mda', 498 => 'mda',
            'me' => 'mne', 'mne' => 'mne', 499 => 'mne',
            'mf' => 'maf', 'maf' => 'maf', 663 => 'maf',
            'mg' => 'mdg', 'mdg' => 'mdg', 450 => 'mdg',
            'mh' => 'mhl', 'mhl' => 'mhl', 584 => 'mhl',
            'mk' => 'mkd', 'mkd' => 'mkd', 807 => 'mkd',
            'ml' => 'mli', 'mli' => 'mli', 466 => 'mli',
            'mm' => 'mmr', 'mmr' => 'mmr', 104 => 'mmr',
            'mn' => 'mng', 'mng' => 'mng', 496 => 'mng',
            'mo' => 'mac', 'mac' => 'mac', 446 => 'mac',
            'mp' => 'mnp', 'mnp' => 'mnp', 580 => 'mnp',
            'mq' => 'mtq', 'mtq' => 'mtq', 474 => 'mtq',
            'mr' => 'mrt', 'mrt' => 'mrt', 478 => 'mrt',
            'ms' => 'msr', 'msr' => 'msr', 500 => 'msr',
            'mt' => 'mlt', 'mlt' => 'mlt', 470 => 'mlt',
            'mu' => 'mus', 'mus' => 'mus', 480 => 'mus',
            'mv' => 'mdv', 'mdv' => 'mdv', 462 => 'mdv',
            'mw' => 'mwi', 'mwi' => 'mwi', 454 => 'mwi',
            'mx' => 'mex', 'mex' => 'mex', 484 => 'mex',
            'my' => 'mys', 'mys' => 'mys', 458 => 'mys',
            'mz' => 'moz', 'moz' => 'moz', 508 => 'moz',
            'na' => 'nam', 'nam' => 'nam', 516 => 'nam',
            'nc' => 'ncl', 'ncl' => 'ncl', 540 => 'ncl',
            'ne' => 'ner', 'ner' => 'ner', 562 => 'ner',
            'nf' => 'nfk', 'nfk' => 'nfk', 574 => 'nfk',
            'ng' => 'nga', 'nga' => 'nga', 566 => 'nga',
            'ni' => 'nic', 'nic' => 'nic', 558 => 'nic',
            'nl' => 'nld', 'nld' => 'nld', 528 => 'nld',
            'no' => 'nor', 'nor' => 'nor', 578 => 'nor',
            'np' => 'npl', 'npl' => 'npl', 524 => 'npl',
            'nr' => 'nru', 'nru' => 'nru', 520 => 'nru',
            'nu' => 'niu', 'niu' => 'niu', 570 => 'niu',
            'nz' => 'nzl', 'nzl' => 'nzl', 554 => 'nzl',
            'om' => 'omn', 'omn' => 'omn', 512 => 'omn',
            'pa' => 'pan', 'pan' => 'pan', 591 => 'pan',
            'pe' => 'per', 'per' => 'per', 604 => 'per',
            'pf' => 'pyf', 'pyf' => 'pyf', 258 => 'pyf',
            'pg' => 'png', 'png' => 'png', 598 => 'png',
            'ph' => 'phl', 'phl' => 'phl', 608 => 'phl',
            'pk' => 'pak', 'pak' => 'pak', 586 => 'pak',
            'pl' => 'pol', 'pol' => 'pol', 616 => 'pol',
            'pm' => 'spm', 'spm' => 'spm', 666 => 'spm',
            'pn' => 'pcn', 'pcn' => 'pcn', 612 => 'pcn',
            'pr' => 'pri', 'pri' => 'pri', 630 => 'pri',
            'ps' => 'pse', 'pse' => 'pse', 275 => 'pse',
            'pt' => 'prt', 'prt' => 'prt', 620 => 'prt',
            'pw' => 'plw', 'plw' => 'plw', 582 => 'plw',
            'py' => 'pry', 'pry' => 'pry', 600 => 'pry',
            'qa' => 'qat', 'qat' => 'qat', 634 => 'qat',
            're' => 'reu', 'reu' => 'reu', 638 => 'reu',
            'ro' => 'rou', 'rou' => 'rou', 642 => 'rou',
            'rs' => 'srb', 'srb' => 'srb', 688 => 'srb',
            'ru' => 'rus', 'rus' => 'rus', 643 => 'rus',
            'rw' => 'rwa', 'rwa' => 'rwa', 646 => 'rwa',
            'sa' => 'sau', 'sau' => 'sau', 682 => 'sau',
            'sb' => 'slb', 'slb' => 'slb', 90 => 'slb',
            'sc' => 'syc', 'syc' => 'syc', 690 => 'syc',
            'sd' => 'sdn', 'sdn' => 'sdn', 729 => 'sdn',
            'se' => 'swe', 'swe' => 'swe', 752 => 'swe',
            'sg' => 'sgp', 'sgp' => 'sgp', 702 => 'sgp',
            'sh' => 'shn', 'shn' => 'shn', 654 => 'shn',
            'si' => 'svn', 'svn' => 'svn', 705 => 'svn',
            'sj' => 'sjm', 'sjm' => 'sjm', 744 => 'sjm',
            'sk' => 'svk', 'svk' => 'svk', 703 => 'svk',
            'sl' => 'sle', 'sle' => 'sle', 694 => 'sle',
            'sm' => 'smr', 'smr' => 'smr', 674 => 'smr',
            'sn' => 'sen', 'sen' => 'sen', 686 => 'sen',
            'so' => 'som', 'som' => 'som', 706 => 'som',
            'sr' => 'sur', 'sur' => 'sur', 740 => 'sur',
            'ss' => 'ssd', 'ssd' => 'ssd', 728 => 'ssd',
            'st' => 'stp', 'stp' => 'stp', 678 => 'stp',
            'sv' => 'slv', 'slv' => 'slv', 222 => 'slv',
            'sy' => 'syr', 'syr' => 'syr', 760 => 'syr',
            'sz' => 'swz', 'swz' => 'swz', 748 => 'swz',
            'tc' => 'tca', 'tca' => 'tca', 796 => 'tca',
            'td' => 'tcd', 'tcd' => 'tcd', 148 => 'tcd',
            'tf' => 'atf', 'atf' => 'atf', 260 => 'atf',
            'tg' => 'tgo', 'tgo' => 'tgo', 768 => 'tgo',
            'th' => 'tha', 'tha' => 'tha', 764 => 'tha',
            'tj' => 'tjk', 'tjk' => 'tjk', 762 => 'tjk',
            'tk' => 'tkl', 'tkl' => 'tkl', 772 => 'tkl',
            'tl' => 'tls', 'tls' => 'tls', 626 => 'tls',
            'tm' => 'tkm', 'tkm' => 'tkm', 795 => 'tkm',
            'tn' => 'tun', 'tun' => 'tun', 788 => 'tun',
            'to' => 'ton', 'ton' => 'ton', 776 => 'ton',
            'tr' => 'tur', 'tur' => 'tur', 792 => 'tur',
            'tt' => 'tto', 'tto' => 'tto', 780 => 'tto',
            'tv' => 'tuv', 'tuv' => 'tuv', 798 => 'tuv',
            'tw' => 'twn', 'twn' => 'twn', 158 => 'twn',
            'tz' => 'tza', 'tza' => 'tza', 834 => 'tza',
            'ua' => 'ukr', 'ukr' => 'ukr', 804 => 'ukr',
            'ug' => 'uga', 'uga' => 'uga', 800 => 'uga',
            'um' => 'umi', 'umi' => 'umi', 581 => 'umi',
            'us' => 'usa', 'usa' => 'usa', 840 => 'usa',
            'uy' => 'ury', 'ury' => 'ury', 858 => 'ury',
            'uz' => 'uzb', 'uzb' => 'uzb', 860 => 'uzb',
            'va' => 'vat', 'vat' => 'vat', 336 => 'vat',
            'vc' => 'vct', 'vct' => 'vct', 670 => 'vct',
            've' => 'ven', 'ven' => 'ven', 862 => 'ven',
            'vg' => 'vgb', 'vgb' => 'vgb', 92 => 'vgb',
            'vi' => 'vir', 'vir' => 'vir', 850 => 'vir',
            'vn' => 'vnm', 'vnm' => 'vnm', 704 => 'vnm',
            'vu' => 'vut', 'vut' => 'vut', 548 => 'vut',
            'wf' => 'wlf', 'wlf' => 'wlf', 876 => 'wlf',
            'ws' => 'wsm', 'wsm' => 'wsm', 882 => 'wsm',
            'ye' => 'yem', 'yem' => 'yem', 887 => 'yem',
            'yt' => 'myt', 'myt' => 'myt', 175 => 'myt',
            'za' => 'zaf', 'zaf' => 'zaf', 710 => 'zaf',
            'zm' => 'zmb', 'zmb' => 'zmb', 894 => 'zmb',
            'zw' => 'zwe', 'zwe' => 'zwe', 716 => 'zwe',
        );
        return $returnArray;
    }
}