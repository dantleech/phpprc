Feature: Apply templates

    Scenario: Apply template to multiple packages
        Given the file "templates/mytemplate.twig":
        """
        Hello {{ package.vendor }}/{{ package.name }} {{ package.title }}
        """
        And the following config:
        """
        {
            "modules": {
                "template": {
                    "source": "templates/my-template.twig",
                    "dest": "README.md"
                }
            }
            "prototype": {
                "apply": [ "template" ],
                "base_path": "base"
            },
            "packages": {
                "vendor1/package1": {
                    "attributes": {
                        "title": "One"
                    }
                },
                "vendor1/package2": {
                    "attributes": {
                        "title": "Two"
                    }
                }
            }
        }
        """
        When I execute "template:apply"
        Then file "base/vendor1/package1/README.md" should exist with contents:
        """
        Hello vendor1/package1 One
        """
        And file "base/vendor1/package2/README.md" should exist with contents:
        """
        Hello vendor1/package2 Two
        """
