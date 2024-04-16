import { Link } from "@inertiajs/react";
import HtmlReactParser from "html-react-parser";

export default function Pagination({ links }) {
  function getClassName(active) {
    if (active) {
      return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary bg-blue-700 text-white";
    }

    return "mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary";
  }

  return (
    links.length > 3 && (
      <div className="mb-4">
        <div className="flex flex-wrap mt-8">
          {links.map((link, key) =>
            link.url === null ? (
              <div
                className="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-white border rounded"
                key={key}
              >
                {HtmlReactParser(link.label)}
              </div>
            ) : (
              <Link
                className={getClassName(link.active) + " text-white"}
                href={link.url}
                key={key}
              >
                {HtmlReactParser(link.label)}
              </Link>
            )
          )}
        </div>
      </div>
    )
  );
}
