<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category   Gc_Application
 * @package    Config
 * @subpackage Form
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace Config\Form;

use Gc\Form\AbstractForm;
use Gc\Document;
use Gc\Layout;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

/**
 * Config form
 *
 * @category   Gc_Application
 * @package    Config
 * @subpackage Form
 */
class Config extends AbstractForm
{
    /**
     * Initialize form
     *
     * @return void
     */
    public function init()
    {
        $this->setInputFilter(new InputFilter());
        $this->setAttribute('class', 'relative form-horizontal');
    }

    /**
     * Initialize General sub form
     *
     * @return \Config\Form\Config
     */
    public function initGeneral()
    {
        //General settings
        $generalFieldset = new Fieldset('general');
        $generalFieldset->setLabel('General');
        $name = new Element\Text('site_name');
        $name->setLabel('Site name')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'site_name')
            ->setAttribute('class', 'form-control');
        $generalFieldset->add($name);

        $this->getInputFilter()->add(
            array(
                'name' => 'site_name',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'site_name'
        );

        $isOffline = new Element\Checkbox('site_is_offline');
        $isOffline->setLabel('Is offline')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'site-offiline')
            ->setCheckedValue('1');
        $generalFieldset->add($isOffline);

        $this->getInputFilter()->add(
            array(
                'name' => 'site_is_offline',
                'required' => false,
            ),
            'site_is_offline'
        );

        $documentCollection = new Document\Collection();
        $documentCollection->load(0);
        $offlineDocument = new Element\Select('site_offline_document');
        $offlineDocument->setLabel('Offline document')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'site_offline_document')
            ->setValueOptions(array('Select document') + $documentCollection->getSelect());
        $generalFieldset->add($offlineDocument);

        $this->getInputFilter()->add(
            array(
                'name' => 'site_offline_document',
                'required' => true,
            ),
            'site_offline_document'
        );

        $layoutCollection = new Layout\Collection();
        $layoutNotFound   = new Element\Select('site_404_layout');
        $layoutNotFound->setLabel('404 layout')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'site_404_layout')
            ->setValueOptions(array('Select document') + $layoutCollection->getSelect());
        $generalFieldset->add($layoutNotFound);

        $this->getInputFilter()->add(
            array(
                'name' => 'site_404_layout',
                'required' => true,
            ),
            'site_404_layout'
        );

        $layoutException = new Element\Select('site_exception_layout');
        $layoutException->setLabel('Exception layout')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'site_exception_layout')
            ->setValueOptions(array('Select document') + $layoutCollection->getSelect());
        $generalFieldset->add($layoutException);
        $this->getInputFilter()->add(
            array(
                'name' => 'site_exception_layout',
                'required' => true,
            ),
            'site_exception_layout'
        );

        $this->add($generalFieldset);

        return $this;
    }

    /**
     * Initialize System sub form
     *
     * @return \Config\Form\Config
     */
    public function initSystem()
    {
        //Session settings
        $sessionFieldset = new Fieldset('session');
        $sessionFieldset->setLabel('Session');
        $cookieDomain = new Element\Text('cookie_domain');
        $cookieDomain->setLabel('Cookie domain')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'cookie_domain')
            ->setAttribute('class', 'form-control');
        $sessionFieldset->add($cookieDomain);

        $this->getInputFilter()->add(
            array(
                'name' => 'cookie_domain',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'cookie_domain'
        );

        $cookiePath = new Element\Text('cookie_path');
        $cookiePath->setLabel('Cookie path')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'cookie_path')
            ->setAttribute('class', 'form-control');
        $sessionFieldset->add($cookiePath);

        $this->getInputFilter()->add(
            array(
                'name' => 'cookie_path',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'cookie_path'
        );

        $sessionHandler = new Element\Select('session_handler');
        $sessionHandler->setLabel('Session handler')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'session_handler')
            ->setValueOptions(array('0' => 'Files', '1' => 'Database'));
        $sessionFieldset->add($sessionHandler);

        $this->getInputFilter()->add(
            array(
                'name' => 'session_handler',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'session_handler'
        );

        $sessionPath = new Element\Text('session_path');
        $sessionPath->setLabel('Session path')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'session_path')
            ->setAttribute('class', 'form-control');
        $sessionFieldset->add($sessionPath);

        $this->getInputFilter()->add(
            array(
                'name' => 'session_path',
                'required' => false,
            ),
            'session_path'
        );

        $sessionLifetime = new Element\Text('session_lifetime');
        $sessionLifetime->setLabel('Session lifetime')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'session_lifetime')
            ->setAttribute('class', 'form-control');
        $sessionFieldset->add($sessionLifetime);

        $this->getInputFilter()->add(
            array(
                'name' => 'session_lifetime',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                    array('name' => 'digits'),
                ),
            ),
            'session_lifetime'
        );

        $this->add($sessionFieldset);

        //Debug settings
        $debugFieldset = new Fieldset('debug');
        $debugFieldset->setLabel('Debug');
        $debugIsActive = new Element\Checkbox('debug_is_active');
        $debugIsActive->setLabel('Debug is active')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'debug_is_active')
            ->setAttribute('id', 'input-checkbox')
            ->setAttribute('class', 'input-checkbox');
        $debugFieldset->add($debugIsActive);

        $this->getInputFilter()->add(
            array(
                'name' => 'debug_is_active',
                'required' => false,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'debug_is_active'
        );

        $this->add($debugFieldset);

        //Cache settings
        $cacheFieldset = new Fieldset('cache');
        $cacheFieldset->setLabel('Cache');
        $cacheIsActive = new Element\Checkbox('cache_is_active');
        $cacheIsActive->setLabel('Cache is active')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'cache_is_active')
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'cache-active');
        $cacheFieldset->add($cacheIsActive);

        $this->getInputFilter()->add(
            array(
                'name' => 'cache_is_active',
                'required' => false,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'cache_is_active'
        );

        $cacheHandler = new Element\Select('cache_handler');
        $cacheHandler->setAttribute('class', 'form-control')
            ->setAttribute('id', 'cache_handler')
            ->setLabel('Cache handler')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            );
        $handlerWhitelist = array('filesystem' => 'FileSystem');
        if (extension_loaded('apc')) {
            $handlerWhitelist['apc'] = 'Apc';
        }

        if (extension_loaded('memcached')) {
            $handlerWhitelist['memcached'] = 'Memcached';
        }

        $cacheHandler->setValueOptions($handlerWhitelist);
        $cacheFieldset->add($cacheHandler);

        $this->getInputFilter()->add(
            array(
                'name' => 'cache_handler',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'cache_handler'
        );

        $cacheLifetime = new Element\Text('cache_lifetime');
        $cacheLifetime->setLabel('Cache lifetime')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'cache_lifetime')
            ->setAttribute('class', 'form-control');
        $cacheFieldset->add($cacheLifetime);

        $this->getInputFilter()->add(
            array(
                'name' => 'cache_lifetime',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                    array('name' => 'digits'),
                ),
            ),
            'cache_lifetime'
        );

        $this->add($cacheFieldset);

        //Stream settings
        $streamFieldset = new Fieldset('stream');
        $streamFieldset->setLabel('Stream Wrapper');

        $isActive = new Element\Checkbox('stream_wrapper_is_active');
        $isActive->setLabel('Stream wrapper is active')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'stream-is-active')
            ->setCheckedValue('1');
        $streamFieldset->add($isActive);

        $this->getInputFilter()->add(
            array(
                'name' => 'stream_wrapper_is_active',
                'required' => false,
            ),
            'stream_wrapper_is_active'
        );

        $this->add($streamFieldset);

        return $this;
    }

    /**
     * Initialize Server sub form
     *
     * @param array $config Configuration
     *
     * @return \Config\Form\Config
     */
    public function initServer($config)
    {
        //Local settings
        $localeFieldset = new Fieldset('locale');
        $localeFieldset->setLabel('Locale');
        $locale = new Element\Select('locale');
        $locale->setLabel('Server locale')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'locale')
            ->setAttribute('class', 'form-control')
            ->setValueOptions($config['locales']);
        $localeFieldset->add($locale);

        $this->getInputFilter()->add(
            array(
                'name' => 'locale',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'locale'
        );

        $this->add($localeFieldset);

        //Mail settings
        $mailFieldset = new Fieldset('mail');
        $mailFieldset->setLabel('Mail');
        $mailFrom = new Element\Text('mail_from');
        $mailFrom->setLabel('From E-mail')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'mail_from')
            ->setAttribute('class', 'form-control');
        $mailFieldset->add($mailFrom);

        $this->getInputFilter()->add(
            array(
                'name' => 'mail_from_name',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'mail_from_name'
        );

        $mailFromName = new Element\Text('mail_from_name');
        $mailFromName->setLabel('From name')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'mail_from_name')
            ->setAttribute('class', 'form-control');
        $mailFieldset->add($mailFromName);

        $this->getInputFilter()->add(
            array(
                'name' => 'mail_from',
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'mail_from'
        );

        $this->add($mailFieldset);

        //Web settings
        $webFieldset = new Fieldset('web');
        $webFieldset->setLabel('Web');

        $forceBackendSsl = new Element\Checkbox('force_backend_ssl');
        $forceBackendSsl->setLabel('Force backend SSL')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'force_backend_ssl')
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'force-backend-ssl');
        $webFieldset->add($forceBackendSsl);

        $this->getInputFilter()->add(
            array(
                'name' => 'force_backend_ssl',
                'required' => false,
            ),
            'force_backend_ssl'
        );

        $forceFrontendSsl = new Element\Checkbox('force_frontend_ssl');
        $forceFrontendSsl->setLabel('Force frontend SSL')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('id', 'force_frontend_ssl')
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'force-frontend-ssl');
        $webFieldset->add($forceFrontendSsl);

        $this->getInputFilter()->add(
            array(
                'name' => 'force_frontend_ssl',
                'required' => false,
            ),
            'force_frontend_ssl'
        );

        $pathFields = array(
            'Unsecure backend base path'  => 'unsecure_backend_base_path',
            'Unsecure frontend base path' => 'unsecure_frontend_base_path',
            'Secure backend base path' => 'secure_backend_base_path',
            'Secure frontend base path' => 'secure_frontend_base_path',
            'Unsecure cdn base path' => 'unsecure_cdn_base_path',
            'Secure cdn base path' => 'secure_cdn_base_path',
        );

        foreach ($pathFields as $label => $identifier) {
            $field = new Element\Text($identifier);
            $field->setLabel($label)
                ->setLabelAttributes(
                    array(
                        'class' => 'required control-label col-lg-2'
                    )
                )
                ->setAttribute('id', $identifier)
                ->setAttribute('class', 'form-control');
            $webFieldset->add($field);

            $this->getInputFilter()->add(
                array(
                    'name' => $identifier,
                    'required' => false,
                    'validators' => array(
                        array('name' => 'uri'),
                    ),
                ),
                $identifier
            );
        }

        $this->add($webFieldset);

        return $this;
    }

    /**
     * Set config values from database result
     *
     * @param array $data The data as array will by passed into form field
     *
     * @return void
     */
    public function setValues(array $data)
    {
        foreach ($data as $config) {
            foreach ($this->getFieldsets() as $fieldset) {
                if ($fieldset->has($config['identifier'])) {
                    $fieldset->get($config['identifier'])->setValue($config['value']);
                    break;
                }
            }
        }
    }
}
