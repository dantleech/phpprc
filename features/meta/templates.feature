Feature: Apply templates

    Scenario: Apply template to multiple packages
        Given the file "templates/mytemplate.twig":
        """
        Hello {{ package.vendor }}/{{ package.name }} {{ package.config.title }}
        """
        And the following config:
        """
        {
            "template.apply": [
                {
                    "source": "templates/mytemplate.twig",
                    "dest": "README.md"
                }
            ],
            "prototype": {
                "base_path": "base"
            },
            "packages": {
                "vendor1/package1": {
                    "config": {
                        "title": "One"
                    }
                },
                "vendor1/package2": {
                    "config": {
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
